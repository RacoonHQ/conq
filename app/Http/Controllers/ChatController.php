<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Services\AI\GroqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    const AGENTS = [
        'thinking_ai' => ['name' => 'Thinking AI', 'model' => 'qwen/qwen3-32b', 'role' => 'system', 'instruction' => 'You are Thinking AI, a creative partner for brainstorming.'],
        'code_ai' => ['name' => 'Code AI', 'model' => 'moonshotai/kimi-k2-instruct-0905', 'role' => 'system', 'instruction' => 'You are Code AI. Provide clean, efficient code. Wrap code in markdown blocks.'],
        'reasoning_ai' => ['name' => 'Reasoning AI', 'model' => 'meta-llama/llama-4-scout-17b-16e-instruct', 'role' => 'system', 'instruction' => 'You are Reasoning AI. Approach problems step-by-step.'],
        'math_ai' => ['name' => 'Math AI', 'model' => 'openai/gpt-oss-120b', 'role' => 'system', 'instruction' => 'You are Math AI. Use LaTeX for equations.'],
    ];

    protected GroqService $groqService;

    public function __construct(GroqService $groqService)
    {
        $this->groqService = $groqService;
    }

    public function index(Request $request)
    {
        $mode = $request->query('mode', 'user');
        $initialPrompt = $request->query('prompt') ?: $request->session()->get('initial_prompt');
        
        return view('chat.index', [
            'mode' => $mode,
            'conversations' => Auth::check() ? Auth::user()->conversations : [],
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
        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json(['error' => 'User not authenticated'], 401);
        }

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

    public function destroy(Request $request, $conversation)
    {
        \Log::info('Delete request received for conversation ID: ' . $conversation);
        \Log::info('User ID: ' . Auth::id());
        
        $convo = Conversation::where('id', $conversation)->where('user_id', Auth::id())->first();
        
        \Log::info('Conversation found: ' . ($convo ? 'yes' : 'no'));
        
        if (!$convo) {
            \Log::error('Conversation not found for ID: ' . $conversation . ' and user: ' . Auth::id());
            return response()->json(['status' => 'error', 'message' => 'Conversation not found'], 404);
        }

        $convo->delete();

        return response()->json(['status' => 'success', 'message' => 'Conversation deleted successfully']);
    }

    public function apiIndex()
    {
        $conversations = Auth::user()->conversations()->get(['id', 'title', 'created_at']);
        return response()->json($conversations);
    }

    public function apiShow(Conversation $conversation)
    {
        if ($conversation->user_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        
        return response()->json([
            'id' => $conversation->id,
            'title' => $conversation->title,
            'agent_id' => $conversation->agent_id,
            'messages' => $conversation->messages,
            'created_at' => $conversation->created_at
        ]);
    }

    public function stream(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'history' => 'array',
            'agent_id' => 'required'
        ]);

        // Check if user has enough credits (5 credits per prompt)
        if (!Auth::check() || !Auth::user()->hasCredits(5)) {
            return response()->json([
                'error' => 'Insufficient credits',
                'redirect' => route('pricing')
            ], 402);
        }

        // Deduct 5 credits for this prompt
        Auth::user()->useCredits(5);

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