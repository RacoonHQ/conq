<?php // Tag pembuka PHP

namespace App\Services\AI; // Definisikan namespace untuk layanan AI

use Illuminate\Support\Facades\Http; // Import HTTP client facade dari Laravel

class GroqService // Definisikan kelas GroqService untuk berinteraksi dengan API Groq AI
{
    protected string $apiKey; // Deklarasikan properti untuk menyimpan API key
    protected string $baseUrl = 'https://api.groq.com/openai/v1/chat/completions'; // Definisikan URL dasar untuk endpoint API Groq

    public function __construct() // Metode konstruktor untuk menginisialisasi layanan
    {
        $this->apiKey = env('GROQ_API_KEY', 'default_key'); // Dapatkan API key dari environment variables atau gunakan default
        if (empty($this->apiKey)) { // Periksa apakah API key kosong atau tidak diatur
            throw new \Exception('GROQ_API_KEY not found in .env file'); // Lempar exception jika API key tidak ditemukan
        }
    }

    public function streamMessage(string $model, array $messages, float $temperature = 0.7) // Metode untuk streaming respons AI
    {
        // Tangani keterbatasan context window untuk model tertentu
        $maxTokens = str_contains($model, 'prompt-guard') ? 512 : 4096; // Atur max tokens berdasarkan tipe model

        return Http::withHeaders([ // Buat HTTP request dengan headers
            'Authorization' => "Bearer {$this->apiKey}", // Atur header authorization dengan Bearer token
            'Content-Type' => 'application/json', // Atur content type ke JSON
        ])->withOptions([ // Konfigurasi opsi tambahan
            'stream' => true, // Aktifkan streaming response
            'sink' => 'php://output', // Langsung output ke response body
        ])->post($this->baseUrl, [ // Buat POST request ke endpoint API
            'model' => $model, // Tentukan model AI yang akan digunakan
            'messages' => $messages, // Kirim pesan percakapan
            'temperature' => $temperature, // Atur parameter kreativitas/randomness
            'max_tokens' => $maxTokens, // Atur maksimum token untuk respons
            'stream' => true, // Aktifkan streaming di request body
        ]);
    }

    public function prepareHistory(array $history, string $prompt, array $agentConfig): array // Metode untuk format history percakapan
    {
        $messages = []; // Inisialisasi array pesan kosong
        
        // Tambahkan Instruksi Sistem
        if (isset($agentConfig['instruction'])) { // Periksa apakah agent memiliki instruksi sistem
            $messages[] = ['role' => 'system', 'content' => $agentConfig['instruction']]; // Tambahkan pesan sistem
        }

        // Peta History
        foreach ($history as $msg) { // Loop melalui history percakapan
            $messages[] = [ // Tambahkan pesan yang sudah diformat ke array
                'role' => $msg['role'] === 'model' ? 'assistant' : 'user', // Ubah 'model' role ke 'assistant'
                'content' => $msg['content'] // Atur konten pesan
            ];
        }

        // Tambahkan Prompt Saat Ini
        $messages[] = ['role' => 'user', 'content' => $prompt]; // Tambahkan prompt user saat ini

        return $messages; // Return array pesan yang sudah diformat
    }
}