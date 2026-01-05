<?php // Awal file PHP

use App\Http\Controllers\AuthController; // Import AuthController untuk fungsi autentikasi
use App\Http\Controllers\ChatController; // Import ChatController untuk fungsi chat/percakapan
use App\Http\Controllers\DashboardController; // Import DashboardController untuk fungsi dashboard
use App\Http\Controllers\PageController; // Import PageController untuk fungsi halaman statis
use App\Http\Controllers\SubscriptionController; // Import SubscriptionController untuk fungsi berlangganan/pembayaran
use Illuminate\Support\Facades\Route; // Import Route facade untuk mendefinisikan route

// Komentar bagian Halaman Statis
Route::get('/', [PageController::class, 'home'])->name('home'); // Route untuk halaman home
Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing'); // Route untuk halaman pricing
Route::get('/help', [PageController::class, 'help'])->name('help'); // Route untuk halaman help
Route::get('/about', [PageController::class, 'about'])->name('about'); // Route untuk halaman about
Route::get('/docs', [PageController::class, 'docs'])->name('docs'); // Route untuk halaman docs

// Komentar bagian Autentikasi
Route::middleware('guest')->group(function () { // Kelompokkan route yang memerlukan akses tamu (belum terautentikasi)
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login'); // GET route untuk form login
    Route::post('/login', [AuthController::class, 'login']); // POST route untuk submit login
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register'); // GET route untuk form registrasi
    Route::post('/register', [AuthController::class, 'register']); // POST route untuk submit registrasi
    Route::get('/forgot-password', [AuthController::class, 'showForgot'])->name('password.request'); // GET route untuk form lupa password
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email'); // POST route untuk mengirim link reset password
}); // Akhir dari grup middleware guest

// Baris kosong untuk jarak
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth'); // POST route untuk logout, memerlukan autentikasi

// Komentar bagian Aplikasi - Terautentikasi
Route::middleware('auth')->group(function () { // Kelompokkan route yang memerlukan autentikasi
    Route::get('/prompt/{conversation}', [ChatController::class, 'show'])->name('chat.show'); // GET route untuk menampilkan percakapan spesifik
    Route::post('/prompt/new', [ChatController::class, 'store'])->name('chat.store'); // POST route untuk membuat percakapan baru
    Route::put('/prompt/{conversation}', [ChatController::class, 'update'])->name('chat.update'); // PUT route untuk memperbarui percakapan
    Route::delete('/prompt/{conversation}', [ChatController::class, 'destroy'])->name('chat.destroy'); // DELETE route untuk menghapus percakapan
    Route::delete('/conversations/destroy-all', [DashboardController::class, 'destroyAll'])->name('conversations.destroyAll'); // DELETE route untuk menghapus semua percakapan

    // Komentar bagian Route API untuk update real-time
    Route::get('/api/conversations', [ChatController::class, 'apiIndex'])->name('api.conversations'); // GET API route untuk daftar percakapan
    Route::get('/api/conversations/{conversation}', [ChatController::class, 'apiShow'])->name('api.conversation.show'); // GET API route untuk percakapan spesifik

// Baris kosong untuk jarak
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); // GET route untuk halaman dashboard
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile'); // GET route untuk halaman profil
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update'); // PUT route untuk memperbarui profil
}); // Akhir dari grup middleware auth

// Komentar bagian Aplikasi - Akses Publik/Tamu
Route::get('/prompt', [ChatController::class, 'index'])->name('chat.index'); // GET route untuk indeks chat (akses publik)
Route::post('/chat/stream', [ChatController::class, 'stream'])->name('chat.stream'); // POST route untuk streaming chat (akses publik)

// Komentar bagian Route Berlangganan
Route::get('/subscription/checkout', [SubscriptionController::class, 'showCheckout'])->name('subscription.checkout'); // GET route untuk halaman checkout berlangganan
Route::post('/subscription/process', [SubscriptionController::class, 'processPayment'])->name('subscription.process'); // POST route untuk memproses pembayaran berlangganan
Route::post('/subscription/contact-sales', [SubscriptionController::class, 'contactSales'])->name('subscription.contact'); // POST route untuk menghubungi sales
Route::get('/upgrade-to-pro', [SubscriptionController::class, 'upgradeToPro'])->name('subscription.upgrade'); // GET route untuk halaman upgrade ke pro