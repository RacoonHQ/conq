<?php // Tag pembuka PHP

namespace App\Http\Controllers; // Definisikan namespace untuk HTTP controllers

use Illuminate\Http\Request; // Import kelas Request dari Laravel
use Illuminate\Support\Facades\Auth; // Import facade Authentication dari Laravel

class SubscriptionController extends Controller // Definisikan SubscriptionController yang extends Controller dasar
{
    public function showCheckout() // Metode untuk menampilkan halaman checkout
    {
        if (!Auth::check()) { // Periksa apakah user tidak terautentikasi
            // Store the intended URL in the session
            session(['payment_redirect' => route('subscription.checkout')]);
            return redirect()->route('login')->with('message', 'Silakan login untuk mengupgrade plan Anda.'); // Redirect ke login dengan pesan
        }

        return view('subscription.checkout'); // Return view halaman checkout
    }

    public function processPayment(Request $request) // Metode untuk memproses pembayaran
    {
        if (!Auth::check()) { // Periksa apakah user tidak terautentikasi
            return redirect()->route('login'); // Redirect ke halaman login
        }

        // Di sini Anda akan mengintegrasikan dengan payment gateway seperti Stripe
        // Untuk sekarang, kita akan simulasikan pembayaran berhasil
        
        $user = Auth::user(); // Dapatkan user yang sedang terautentikasi
        
        // Update status subscription user (Anda akan memiliki tabel subscription di aplikasi nyata)
        // Untuk demo, kita akan redirect dengan pesan sukses
        
        return redirect()->route('dashboard')->with('success', 'Berhasil upgrade ke plan Pro!'); // Redirect ke dashboard dengan pesan sukses
    }

    public function contactSales(Request $request) // Metode untuk menangani form kontak sales
    {
        $request->validate([ // Validasi data request yang masuk
            'name' => 'required|string|max:255', // Nama wajib, string, maksimal 255 karakter
            'email' => 'required|email|max:255', // Email wajib, valid, maksimal 255 karakter
            'company' => 'nullable|string|max:255', // Perusahaan opsional, string, maksimal 255 karakter
            'message' => 'required|string|max:1000', // Pesan wajib, string, maksimal 1000 karakter
        ]);

        // Di sini Anda akan mengirim email ke tim sales Anda
        // Untuk sekarang, kita akan redirect dengan pesan sukses
        
        return redirect()->back()->with('success', 'Terima kasih atas minat Anda! Tim sales kami akan menghubungi Anda segera.'); // Return kembali dengan pesan sukses
    }

    public function upgradeToPro() // Metode untuk menangani upgrade ke plan Pro
{
    if (!Auth::check()) { // Periksa apakah user tidak terautentikasi
        // Simpan URL tujuan di session
        session(['payment_redirect' => route('subscription.checkout')]);
        return redirect()->route('login')->with('message', 'Silakan login untuk mengupgrade plan Anda.');
    }

    return redirect()->route('subscription.checkout'); // Arahkan ke halaman checkout
}
}
