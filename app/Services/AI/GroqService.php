<?php // Tag pembuka PHP

namespace App\Services\AI; // Namespace untuk service AI

use Illuminate\Support\Facades\Http; // Import facade HTTP untuk request
use Illuminate\Support\Facades\Log;  // Import facade Log untuk logging
use Exception; // Import class Exception untuk penanganan error

class GroqService // Kelas utama untuk menangani koneksi ke API Groq
{
    protected string $apiKey; // Property untuk menyimpan API key
    protected string $baseUrl = 'https://api.groq.com/openai/v1/chat/completions'; // URL endpoint API Groq
    protected int $timeout = 30; // Waktu timeout request dalam detik

    /**
     * Konstruktor untuk inisialisasi service
     * @throws Exception Jika API key tidak ditemukan
     */
    public function __construct()
    {
        // Mengambil API key dari environment variable
        $this->apiKey = env('GROQ_API_KEY', '');
        
        // Validasi API key
        if (empty($this->apiKey) || $this->apiKey === 'your_groq_api_key_here') {
            throw new Exception('GROQ_API_KEY tidak dikonfigurasi dengan benar di file .env');
        }
    }

    /**
     * Mengirim permintaan streaming ke API Groq
     *
     * @param string $model Nama model AI yang akan digunakan
     * @param array $messages Array pesan percakapan
     * @param float $temperature Nilai temperature untuk kreativitas (0.0 - 1.0)
     * @return bool True jika berhasil, false jika gagal
     * @throws \Exception Jika terjadi error
     */
    public function streamMessage(string $model, array $messages, float $temperature = 0.7)
    {
        try {
            // Tentukan jumlah token maksimum berdasarkan model
            $maxTokens = str_contains($model, 'prompt-guard') ? 512 : 4096;
            
            // Catat informasi request untuk debugging
            Log::debug('Mengirim request ke API Groq', [
                'model' => $model, // Model AI yang digunakan
                'message_count' => count($messages), // Jumlah pesan dalam percakapan
                'temperature' => $temperature, // Nilai temperature untuk kreativitas
                'max_tokens' => $maxTokens // Jumlah token maksimum
            ]);

            // Matikan output buffering untuk memungkinkan streaming
            if (ob_get_level() > 0) {
                ob_end_flush(); // Hentikan output buffering yang aktif
            }
            ob_implicit_flush(true); // Aktifkan pengiriman output langsung

            // Set header untuk Server-Sent Events (SSE)
            header('Content-Type: text/event-stream'); // Tipe konten untuk SSE
            header('Cache-Control: no-cache'); // Nonaktifkan cache
            header('Connection: keep-alive'); // Pertahankan koneksi tetap hidup
            header('X-Accel-Buffering: no'); // Nonaktifkan buffering untuk Nginx
            
            // Buat request HTTP ke API Groq dengan konfigurasi streaming
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}", // API key untuk autentikasi
                'Content-Type' => 'application/json', // Tipe konten yang dikirim
                'Accept' => 'text/event-stream', // Menerima response dalam format event stream
            ])->withOptions([
                'timeout' => $this->timeout, // Set timeout request
                'stream' => true, // Aktifkan mode streaming
            ])->post($this->baseUrl, [ // Kirim request POST ke URL API
                'model' => $model, // Model AI yang digunakan
                'messages' => $messages, // Pesan percakapan
                'temperature' => $temperature, // Nilai temperature untuk kreativitas
                'max_tokens' => $maxTokens, // Batas token respons
                'stream' => true, // Aktifkan streaming dari API
            ]);

            // Periksa jika terjadi error pada response
            if ($response->failed()) {
                // Ambil detail error dari response JSON
                $error = $response->json();
                
                // Catat error ke log
                Log::error('Error dari API Groq', [
                    'status' => $response->status(), // Kode status HTTP
                    'error' => $error, // Pesan error dari API
                    'response_headers' => $response->headers() // Header response
                ]);
                
                // Kirim pesan error sebagai event SSE ke client
                $this->sendErrorEvent('Error API: ' . ($error['error']['message'] ?? 'Kesalahan tidak diketahui'));
                return false; // Mengembalikan false menandakan gagal
            }

            // Dapatkan body response dari API
            $body = $response->body();
            
            // Periksa jika body response kosong
            if (empty($body)) {
                // Catat kejadian response kosong ke log
                Log::error('Response body kosong dari API Groq', [
                    'status' => $response->status(), // Kode status HTTP
                    'headers' => $response->headers() // Header response
                ]);
                
                // Kirim notifikasi error ke client
                $this->sendErrorEvent('Menerima response kosong dari API');
                return false; // Mengembalikan false menandakan gagal
            }
            
            // Tampilkan response langsung ke output
            echo $body;
            
            // Pastikan output langsung terkirim ke client
            if (ob_get_level() > 0) {
                ob_flush(); // Kosongkan output buffer
            }
            flush(); // Paksa kirim output ke client
            
            return true; // Mengembalikan true menandakan sukses
            
        } catch (\Exception $e) {
            // Catat error yang terjadi ke dalam log
            Log::error('Error di GroqService::streamMessage', [
                'error' => $e->getMessage(), // Pesan error
                'trace' => $e->getTraceAsString() // Stack trace untuk debugging
            ]);
            
            // Kirim error sebagai event SSE jika header belum dikirim
            if (!headers_sent()) {
                $this->sendErrorEvent('Error: ' . $e->getMessage());
            }
            
            return false; // Mengembalikan false menandakan terjadi error
        }
    }
    
    /**
     * Mengirim pesan error sebagai Server-Sent Event (SSE)
     * 
     * @param string $message Pesan error yang akan dikirim
     * @return void
     */
    protected function sendErrorEvent(string $message): void
    {
        // Jika header sudah dikirim, tidak bisa mengirim event SSE lagi
        if (headers_sent()) {
            return;
        }
        
        // Format pesan error sebagai SSE
        echo "event: error\n"; // Nama event
        echo 'data: ' . json_encode(['error' => $message]) . "\n\n"; // Data dalam format JSON
        
        // Pastikan output langsung terkirim
        if (ob_get_level() > 0) {
            ob_flush(); // Kosongkan output buffer
        }
        flush(); // Paksa kirim output ke client
    }

    /**
     * Mempersiapkan history percakapan untuk dikirim ke API
     * 
     * @param array $history Array berisi history percakapan
     * @param string $prompt Pesan terbaru dari pengguna
     * @param array $agentConfig Konfigurasi agent AI yang digunakan
     * @return array Array pesan yang sudah diformat untuk API
     */
    public function prepareHistory(array $history, string $prompt, array $agentConfig): array
    {
        $messages = []; // Inisialisasi array untuk menyimpan pesan
        
        // Tambahkan instruksi sistem jika ada di konfigurasi agent
        if (isset($agentConfig['instruction'])) {
            $messages[] = [
                'role' => 'system', 
                'content' => $agentConfig['instruction']
            ];
        }

        // Konversi history ke format yang diharapkan API
        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg['role'] === 'model' ? 'assistant' : 'user',
                'content' => $msg['content']
            ];
        }

        // Tambahkan prompt terbaru dari pengguna
        $messages[] = [
            'role' => 'user', 
            'content' => $prompt
        ];

        return $messages; // Kembalikan array pesan yang sudah diformat
    }
}