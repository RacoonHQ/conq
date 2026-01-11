<?php // Tag pembuka PHP

namespace App\Http\Controllers; // Definisikan namespace untuk HTTP controllers

use App\Models\Conversation; // Import model Conversation
use App\Services\AI\GroqService; // Import layanan Groq AI
use Illuminate\Http\Request; // Import kelas Request dari Laravel
use Illuminate\Support\Facades\Auth; // Import facade Authentication dari Laravel

class ChatController extends Controller // Definisikan ChatController yang extends Controller dasar
{
    const AGENTS = [ // Definisikan array konstan dari agent AI yang tersedia
        'thinking_ai' => ['name' => 'Thinking AI', 'model' => 'qwen/qwen3-32b', 'role' => 'system', 'instruction' => 'You are Thinking AI, a creative partner for brainstorming. Always use Markdown for formatting. For structured data, ALWAYS use Markdown tables. Below complex tables, provide a relevant code block (e.g., Python, C++, or Bash) if it helps explain the data or provides a practical example/template.'], // Konfigurasi agent Thinking AI
        'code_ai' => ['name' => 'Code AI', 'model' => 'moonshotai/kimi-k2-instruct-0905', 'role' => 'system', 'instruction' => 'You are Code AI. Provide clean, efficient code. Wrap code in markdown blocks with language headers. After presenting comparisons or technical specs in tables, provide a full code implementation or usage example in a code block below.'], // Konfigurasi agent Code AI
        'reasoning_ai' => ['name' => 'Reasoning AI', 'model' => 'meta-llama/llama-4-scout-17b-16e-instruct', 'role' => 'system', 'instruction' => 'You are Reasoning AI. Approach problems step-by-step. Use Markdown tables for data. Below tables, provide technical snippets, configuration examples, or pseudo-code to illustrate the reasoning.'], // Konfigurasi agent Reasoning AI
        'math_ai' => ['name' => 'Math AI', 'model' => 'openai/gpt-oss-120b', 'role' => 'system', 'instruction' => 'You are Math AI. Use LaTeX for equations. Use Markdown tables for results. Below tables, provide code snippets (e.g., Python/MATLAB) to perform the calculations or simulations shown.'], // Konfigurasi agent Math AI
    ];

    protected GroqService $groqService; // Deklarasikan properti untuk menyimpan instance GroqService

    public function __construct(GroqService $groqService) // Konstruktor dengan dependency injection
    {
        $this->groqService = $groqService; // Inject dan simpan instance GroqService
    }

    public function index(Request $request) // Metode untuk menampilkan halaman chat index
    {
        $mode = $request->query('mode', 'user'); // Dapatkan mode dari query string, default ke 'user'
        $initialPrompt = $request->query('prompt') ?: $request->session()->get('initial_prompt'); // Dapatkan initial prompt dari query atau session
        
        return view('chat.index', [ // Return view chat index dengan data
            'mode' => $mode, // Kirim mode ke view
            'conversations' => Auth::check() ? Auth::user()->conversations : [], // Kirim percakapan user atau array kosong jika tidak terautentikasi
            'currentConversation' => null, // Tidak ada percakapan saat ini untuk chat baru
            'initialPrompt' => $initialPrompt, // Kirim initial prompt ke view
            'initialAgent' => $request->query('agent', 'thinking_ai'), // Dapatkan agent dari query, default ke thinking_ai
            'agents' => self::AGENTS // Kirim semua agent yang tersedia ke view
        ]);
    }

    public function show(Conversation $conversation) // Metode untuk menampilkan percakapan spesifik
    {
        if ($conversation->user_id !== Auth::id()) abort(403); // Periksa apakah user memiliki percakapan, abort dengan 403 jika tidak

        return view('chat.index', [ // Return view chat index dengan data percakapan
            'mode' => 'user', // Atur mode ke user
            'conversations' => Auth::user()->conversations, // Kirim semua percakapan user
            'currentConversation' => $conversation, // Kirim percakapan spesifik
            'initialPrompt' => null, // Tidak ada initial prompt untuk percakapan yang ada
            'initialAgent' => $conversation->agent_id, // Atur agent dari percakapan
            'agents' => self::AGENTS // Kirim semua agent yang tersedia
        ]);
    }

    public function store(Request $request) // Metode untuk menyimpan percakapan baru
    {
        // Periksa apakah user terautentikasi
        if (!Auth::check()) { // Verifikasi user sudah login
            return response()->json(['error' => 'User tidak terautentikasi'], 401); // Return error 401 jika tidak terautentikasi
        }

        // Digunakan untuk menyimpan konteks chat setelah pesan pertama
        $convo = Conversation::create([ // Buat percakapan baru di database
            'user_id' => Auth::id(), // Atur user ID ke user yang sedang terautentikasi
            'title' => substr($request->input('message'), 0, 30) . '...', // Buat judul dari 30 karakter pertama pesan
            'agent_id' => $request->input('agent_id'), // Atur agent AI yang digunakan
            'messages' => $request->input('messages') // Menyimpan history awal
        ]);

        return response()->json(['id' => $convo->id]); // Return response JSON dengan ID percakapan baru
    }

    public function update(Request $request, Conversation $conversation) // Metode untuk mengupdate percakapan yang ada
    {
        if ($conversation->user_id !== Auth::id()) abort(403); // Periksa apakah user memiliki percakapan, abort dengan 403 jika tidak

        $conversation->update([ // Update percakapan dengan data baru
            'messages' => $request->input('messages') // Update array pesan
        ]);

        return response()->json(['status' => 'success']); // Return status sukses dalam response JSON
    }

    public function destroy(Request $request, $conversation) // Metode untuk menghapus percakapan
    {
        \Log::info('Permintaan hapus diterima untuk ID percakapan: ' . $conversation); // Log permintaan hapus
        \Log::info('ID User: ' . Auth::id()); // Log ID user
        
        $convo = Conversation::where('id', $conversation)->where('user_id', Auth::id())->first(); // Cari percakapan yang dimiliki user
        
        \Log::info('Percakapan ditemukan: ' . ($convo ? 'ya' : 'tidak')); // Log apakah percakapan ditemukan
        
        if (!$convo) { // Periksa apakah percakapan ada
            \Log::error('Percakapan tidak ditemukan untuk ID: ' . $conversation . ' dan user: ' . Auth::id()); // Log error jika tidak ditemukan
            return response()->json(['status' => 'error', 'message' => 'Percakapan tidak ditemukan'], 404); // Return error 404
        }

        $convo->delete(); // Hapus percakapan

        return response()->json(['status' => 'success', 'message' => 'Percakapan berhasil dihapus']); // Return pesan sukses
    }

    public function apiIndex() // Metode untuk mengembalikan percakapan sebagai JSON untuk API
    {
        $conversations = Auth::user()->conversations()->get(['id', 'title', 'created_at']); // Dapatkan percakapan user dengan field tertentu
        return response()->json($conversations); // Return percakapan sebagai response JSON
    }

    public function apiShow(Conversation $conversation) // Metode untuk mengembalikan percakapan spesifik sebagai JSON untuk API
    {
        if ($conversation->user_id !== Auth::id()) { // Periksa apakah user memiliki percakapan
            return response()->json(['error' => 'Tidak diizinkan'], 403); // Return error 403 jika tidak diizinkan
        }
        
        return response()->json([ // Return data percakapan sebagai JSON
            'id' => $conversation->id, // ID percakapan
            'title' => $conversation->title, // Judul percakapan
            'agent_id' => $conversation->agent_id, // Agent yang digunakan dalam percakapan
            'messages' => $conversation->messages, // Pesan percakapan
            'created_at' => $conversation->created_at // Timestamp pembuatan
        ]);
    }

    public function stream(Request $request) // Metode untuk menangani streaming respons AI
    {
        $request->validate([ // Validasi data request yang masuk
            'message' => 'required', // Field pesan wajib diisi
            'history' => 'array', // Field history harus berupa array
            'agent_id' => 'required' // Field agent ID wajib diisi
        ]);

        // Periksa apakah user memiliki cukup kredit (5 kredit per prompt)
        if (!Auth::check() || !Auth::user()->hasCredits(5)) { // Periksa autentikasi dan saldo kredit
            return response()->json([ // Return response error
                'error' => 'Kredit tidak mencukupi', // Pesan error
                'redirect' => route('pricing') // Redirect ke halaman pricing
            ], 402); // HTTP status 402 Payment Required
        }

        // Periksa percobaan upload file dari tamu
        if (!Auth::check() && str_contains($request->message, '[Attached File:')) { // Periksa apakah tamu mencoba upload file
            return response()->json([ // Return response error
                'error' => 'Upload file hanya tersedia untuk user terdaftar. Silakan daftar untuk mengupload file.', // Pesan error
                'redirect' => route('register') // Redirect ke halaman registrasi
            ], 403); // HTTP status 403 Forbidden
        }

        // Potong 5 kredit untuk prompt ini
        Auth::user()->useCredits(5); // Potong kredit dari akun user

        $agentConfig = self::AGENTS[$request->agent_id] ?? self::AGENTS['thinking_ai']; // Dapatkan konfigurasi agent atau default ke thinking_ai
        $messages = $this->groqService->prepareHistory($request->history, $request->message, $agentConfig); // Siapkan history pesan untuk API

        return response()->stream(function () use ($messages, $agentConfig) { // Return response streaming
            $this->groqService->streamMessage($agentConfig['model'], $messages); // Panggil streaming yang langsung output
        }, 200, [ // Atur header response
            'Content-Type' => 'text/event-stream', // Atur content type untuk server-sent events
            'Cache-Control' => 'no-cache', // Mencegah caching response streaming
            'Connection' => 'keep-alive', // Pertahankan koneksi untuk streaming
        ]);
    }
}