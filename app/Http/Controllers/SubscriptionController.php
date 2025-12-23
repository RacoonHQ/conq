<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function showCheckout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to upgrade your plan.');
        }

        return view('subscription.checkout');
    }

    public function processPayment(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Here you would integrate with a payment gateway like Stripe
        // For now, we'll just simulate a successful payment
        
        $user = Auth::user();
        
        // Update user's subscription status (you'd have a subscription table in real app)
        // For demo purposes, we'll just redirect with success message
        
        return redirect()->route('dashboard')->with('success', 'Successfully upgraded to Pro plan!');
    }

    public function contactSales(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string|max:1000',
        ]);

        // Here you would send an email to your sales team
        // For now, we'll just redirect with success message
        
        return redirect()->back()->with('success', 'Thank you for your interest! Our sales team will contact you soon.');
    }

    public function upgradeToPro()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to upgrade your plan.');
        }

        return redirect()->route('subscription.checkout');
    }
}
