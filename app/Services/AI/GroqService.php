<?php

namespace App\Services\AI;

use Illuminate\Support\Facades\Http;

class GroqService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.groq.com/openai/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = env('GROQ_API_KEY', 'default_key');
        if (empty($this->apiKey)) {
            throw new \Exception('GROQ_API_KEY not found in .env file');
        }
    }

    public function streamMessage(string $model, array $messages, float $temperature = 0.7)
    {
        // Handle context window limitations for specific models
        $maxTokens = str_contains($model, 'prompt-guard') ? 512 : 4096;

        return Http::withHeaders([
            'Authorization' => "Bearer {$this->apiKey}",
            'Content-Type' => 'application/json',
        ])->withOptions([
            'stream' => true,
        ])->post($this->baseUrl, [
            'model' => $model,
            'messages' => $messages,
            'temperature' => $temperature,
            'max_tokens' => $maxTokens,
            'stream' => true,
        ]);
    }

    public function prepareHistory(array $history, string $prompt, array $agentConfig): array
    {
        $messages = [];
        
        // Add System Instruction
        if (isset($agentConfig['instruction'])) {
            $messages[] = ['role' => 'system', 'content' => $agentConfig['instruction']];
        }

        // Map History
        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg['role'] === 'model' ? 'assistant' : 'user',
                'content' => $msg['content']
            ];
        }

        // Add Current Prompt
        $messages[] = ['role' => 'user', 'content' => $prompt];

        return $messages;
    }
}