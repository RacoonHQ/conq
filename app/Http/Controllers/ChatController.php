<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Services\AI\GroqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    const AGENTS = [
        'thinking_ai' => ['name' => 'Thinking AI', 'model' => 'llama-3.1-8b-instant', 'role' => 'system', 'instruction' => 'You are Thinking AI, a creative partner for brainstorming.'],
        'code_ai' => ['name' => 'Code AI', 'model' => 'llama-3.3-70b-versatile', 'role' => 'system', 'instruction' => 'You are Code AI. Provide clean, efficient code. Wrap code in markdown blocks.'],
        'reasoning_ai' => ['name' => 'Reasoning AI', 'model' => 'llama-3.3-70b-versatile', 'role' => 'system', 'instruction' => 'You are Reasoning AI. Approach problems step-by-step.'],
        'math_ai' => ['name' => 'Math AI', 'model' => 'llama-3.3-70b-versatile', 'role' => 'system', 'instruction' => 'You are Math AI. Use LaTeX for equations.'],
    ];

    protected GroqService $groqService;

    public function __construct(GroqService $groqService)
    {
        $this->groqService = $groqService;
    }

    public function index(Request $request)
    {
        $mode = $request->query('mode', 'user');
        $initialPrompt = $request->session()->get('initial_prompt');
        
        return view('chat.index', [
            'mode' => $mode,
            'conversations' => Auth::user()->conversations,
            'currentConversation' => null,
            'initialPrompt' => $initialPrompt,
            'initialAgent' => $request->query('agent', 'thinking_ai'),
            'agents' => self::AGENTS
        ]);
    }

    public function show(Conversation $conversation)
    {
        if ($conversation->user_id !== Auth::id()) abort(403);

        return view('chat.index', [
            'mode' => 'user',
            'conversations' => Auth::user()->conversations,
            'currentConversation' => $conversation,
            'initialPrompt' => null,
            'initialAgent' => $conversation->agent_id,
            'agents' => self::AGENTS
        ]);
    }

    public function store(Request $request)
    {
        // Used to save chat context after first message
        $convo = Conversation::create([
            'user_id' => Auth::id(),
            'title' => substr($request->input('message'), 0, 30) . '...',
            'agent_id' => $request->input('agent_id'),
            'messages' => $request->input('messages') // Saving initial history
        ]);

        return response()->json(['id' => $convo->id]);
    }

    public function update(Request $request, Conversation $conversation)
    {
        if ($conversation->user_id !== Auth::id()) abort(403);

        $conversation->update([
            'messages' => $request->input('messages')
        ]);

        return response()->json(['status' => 'success']);
    }

    public function stream(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'history' => 'array',
            'agent_id' => 'required'
        ]);

        $agentConfig = self::AGENTS[$request->agent_id] ?? self::AGENTS['thinking_ai'];
        $messages = $this->groqService->prepareHistory($request->history, $request->message, $agentConfig);

        return response()->stream(function () use ($messages, $agentConfig) {
            $response = $this->groqService->streamMessage($agentConfig['model'], $messages);
            $body = $response->toPsrResponse()->getBody();

            while (!$body->eof()) {
                echo $body->read(1024);
                flush();
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ]);
    }
}