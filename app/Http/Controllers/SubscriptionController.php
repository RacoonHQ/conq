<?php // Tag pembuka PHP

namespace App\Http\Controllers; // Definisikan namespace untuk HTTP controllers

use Illuminate\Http\Request; // Import kelas Request dari Laravel
use Illuminate\Support\Facades\Auth; // Import facade Authentication dari Laravel

class SubscriptionController extends Controller
{
    public function showCheckout()
    {
        if (!Auth::check()) {
            // Store the intended URL in the session
            session(['payment_redirect' => route('subscription.checkout')]);
            return redirect()->route('login')->with('message', 'Silakan login untuk mengupgrade plan Anda.');
        }

        $features = [
            'Everything in Starter',
            'Unlimited queries',
            'Access to Reasoning AI',
            'Access to Math AI',
            'Priority response speed',
            'Early access to new features'
        ];

        return view('subscription.checkout', compact('features'));
    }

    public function processPayment(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Simulasi pembayaran berhasil (Manual tanpa integrasi payment gateway)
        
        $user = Auth::user();
        
        // Update plan user ke Pro
        $message = 'Selamat! Akun Anda telah diupgrade ke plan Pro.';
        
        if ($user->plan === 'Pro') {
            // User sudah Pro, perpanjang dari tanggal expire saat ini
            $currentExpiry = $user->subscription_expires_at ?? now();
            $user->subscription_expires_at = $currentExpiry->addMonth();
            $user->save();
            $message = 'Berhasil! Langganan Pro Anda telah diperpanjang selama 1 bulan.';
        } else {
            // User baru upgrade ke Pro
            $user->plan = 'Pro';
            $user->subscription_expires_at = now()->addMonth();
            $user->save();
        }
        
        return redirect()->route('dashboard')->with('success', $message);
    }

    public function contactSales(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Di sini Anda akan mengirim email ke tim sales Anda
        // Untuk sekarang, kita akan redirect dengan pesan sukses
        
        return redirect()->back()->with('success', 'Terima kasih atas minat Anda! Tim sales kami akan menghubungi Anda segera.');
    }

    public function upgradeToPro()
    {
        if (!Auth::check()) {
            session(['payment_redirect' => route('subscription.checkout')]);
            return redirect()->route('login')->with('message', 'Silakan login untuk mengupgrade plan Anda.');
        }

        return redirect()->route('subscription.checkout');
    }

    public function manage()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        return view('subscription.managesubs', compact('user'));
    }
}
