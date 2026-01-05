<?php // Tag pembuka PHP

namespace App\Http\Controllers; // Definisikan namespace untuk HTTP controllers

use Illuminate\Support\Facades\Auth; // Import facade Authentication dari Laravel

class DashboardController extends Controller // Definisikan DashboardController yang extends Controller dasar
{
    public function index() // Metode untuk menampilkan halaman dashboard
    {
        $user = Auth::user(); // Dapatkan user yang sedang terautentikasi
        $history = $user->conversations; // Dapatkan semua percakapan user
        
        // Hitung total prompt/pesan dari semua percakapan
        $totalPrompts = 0; // Inisialisasi counter total prompt
        foreach ($history as $conversation) { // Loop melalui setiap percakapan
            $messages = $conversation->messages ?? []; // Dapatkan pesan atau array kosong jika null
            // Hitung pesan user (prompt) - asumsikan pesan user memiliki 'role' => 'user'
            foreach ($messages as $message) { // Loop melalui setiap pesan
                if (isset($message['role']) && $message['role'] === 'user') { // Periksa apakah pesan dari user
                    $totalPrompts++; // Tambah counter prompt
                }
            }
        }
        
        $totalQueries = $totalPrompts; // Atur total query sama dengan total prompt
        $timeSaved = round($totalPrompts * 0.5); // 0.5 jam dihemat per prompt (30 menit)
        $remainingCredits = $user->remaining_credits; // Dapatkan kredit tersisa user

        return view('dashboard', compact('user', 'history', 'totalQueries', 'timeSaved', 'remainingCredits')); // Return view dashboard dengan data
    }

    public function destroyAll() // Metode untuk menghapus semua percakapan user
    {
        $user = Auth::user(); // Dapatkan user yang sedang terautentikasi
        $user->conversations()->delete(); // Hapus semua percakapan yang dimiliki user
        
        return redirect()->route('dashboard')->with('success', 'Semua percakapan telah dihapus.'); // Redirect ke dashboard dengan pesan sukses
    }
}