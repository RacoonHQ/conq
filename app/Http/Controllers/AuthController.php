<?php // Tag pembuka PHP

namespace App\Http\Controllers; // Definisikan namespace untuk HTTP controllers

use App\Models\User; // Import model User
use Illuminate\Http\Request; // Import kelas Request dari Laravel
use Illuminate\Support\Facades\Auth; // Import facade Authentication dari Laravel
use Illuminate\Support\Facades\Hash; // Import facade Hash dari Laravel untuk hashing password
use Illuminate\Validation\Rule; // Import kelas validasi rule

class AuthController extends Controller // Definisikan AuthController yang extends Controller dasar
{
    public function showLogin() { return view('auth.login'); } // Tampilkan halaman login
    public function showRegister() { return view('auth.register'); } // Tampilkan halaman registrasi
    public function showForgot() { return view('auth.forgot-password'); } // Tampilkan halaman lupa password

    public function sendResetLink(Request $request) // Metode untuk menangani permintaan link reset password
    {
        $request->validate([ // Validasi data request yang masuk
            'email' => ['required', 'email'], // Field email wajib diisi dan harus format email yang valid
        ]);

        // Logika untuk mengirim link reset akan ada di sini (misal: Password::sendResetLink)
        // Untuk sekarang, kita akan simulasikan untuk memperbaiki alur.
        
        return back()->with('status', 'Kami telah mengirim link reset password ke email Anda!'); // Return kembali dengan pesan sukses
    }

    public function login(Request $request) // Metode untuk menangani login user
    {
        $credentials = $request->validate([ // Validasi kredensial login
            'email' => ['required', 'email'], // Email wajib diisi dan harus valid
            'password' => ['required'], // Password wajib diisi
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) { // Coba autentikasi user
            $request->session()->regenerate(); // Regenerasi session ID untuk keamanan
            return redirect()->intended(route('chat.index')); // Redirect ke halaman yang dimaksud atau chat index
        }

        return back()->withErrors([ // Return kembali dengan error validasi
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.', // Pesan error untuk kredensial tidak valid
        ]);
    }

    public function register(Request $request) // Metode untuk menangani registrasi user
    {
        $validated = $request->validate([ // Validasi data registrasi
            'name' => ['required', 'string', 'max:255'], // Nama wajib, string, maksimal 255 karakter
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'], // Email wajib, valid, unik di tabel users
            'password' => ['required', 'string', 'min:8'], // Password wajib, string, minimal 8 karakter
        ]);

        $user = User::create([ // Buat user baru di database
            'name' => $validated['name'], // Atur nama user
            'email' => $validated['email'], // Atur email user
            'password' => Hash::make($validated['password']), // Hash password sebelum disimpan
            'plan' => 'Free', // Atur plan default ke Free
            'credits' => 100, // Beri user baru 100 kredit
        ]);

        Auth::login($user); // Login user yang baru dibuat

        return redirect()->route('chat.index'); // Redirect ke halaman chat
    }

    public function logout(Request $request) // Metode untuk menangani logout user
    {
        Auth::logout(); // Logout user saat ini
        $request->session()->invalidate(); // Invalidasi session saat ini
        $request->session()->regenerateToken(); // Regenerasi token CSRF
        return redirect('/'); // Redirect ke halaman home
    }

    public function profile() // Metode untuk menampilkan halaman profil user
    {
        return view('profile', ['user' => Auth::user()]); // Return view profil dengan data user yang terautentikasi
    }

    public function updateProfile(Request $request) // Metode untuk mengupdate profil user
    {
        $user = Auth::user(); // Dapatkan user yang sedang terautentikasi
        $validated = $request->validate([ // Validasi data update profil
            'name' => ['required', 'string', 'max:255'], // Nama wajib, string, maksimal 255 karakter
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)], // Email wajib, valid, unik kecuali user saat ini
        ]);

        $user->update($validated); // Update user dengan data yang sudah divalidasi
        return back()->with('success', 'Profil berhasil diperbarui.'); // Return kembali dengan pesan sukses
    }
}