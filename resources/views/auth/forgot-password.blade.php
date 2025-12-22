@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center p-4 bg-[#121212] relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#00D4FF] to-[#64FDDA]"></div>
    
    <a href="{{ route('login') }}" class="absolute top-8 left-8 text-[#A0A0A0] hover:text-white flex items-center transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg> Back
    </a>

    <div class="w-full max-w-md bg-[#1A1A1A] rounded-2xl border border-[#333] p-8 shadow-2xl relative z-10">
        <div class="flex justify-center mb-6">
            <h1 class="text-3xl font-bold tracking-tight text-white font-['Inter']">CONQ<span class="text-[#00D4FF]">.</span></h1>
        </div>
        
        <h2 class="text-2xl font-bold text-center text-white mb-2">Reset Password</h2>

        @if (session('status'))
            <div class="text-center animate-pulse">
                <div class="bg-[#121212] border border-[#00D4FF]/30 p-4 rounded-lg mb-6 mt-6">
                    <p class="text-sm text-[#E0E0E0]">{{ session('status') }}</p>
                </div>
                <p class="text-xs text-[#666] mb-6">Check your inbox and spam folder.</p>
                <a href="{{ route('login') }}" class="block w-full py-3 rounded-lg font-semibold text-[#00D4FF] border border-[#00D4FF]/30 hover:bg-[#00D4FF]/10 mt-2 transition-colors text-center">
                    Return to Login
                </a>
            </div>
        @else
            <p class="text-center text-[#A0A0A0] mb-8 text-sm">Enter your email address and we'll send you instructions to reset your password.</p>
            
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-[#A0A0A0] mb-1.5 uppercase tracking-wide">Email Address</label>
                    <input type="email" name="email" required class="w-full bg-[#121212] border border-[#333] rounded-lg py-2.5 px-4 text-white focus:outline-none focus:border-[#00D4FF] transition-colors text-sm" placeholder="you@example.com">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full py-3 rounded-lg font-semibold text-black mt-4 bg-[#00D4FF] hover:bg-[#64FDDA] transition-colors">
                    Send Link
                </button>
            </form>

            <div class="mt-6 text-center text-sm text-[#666]">
                Remember your password? <a href="{{ route('login') }}" class="text-white font-medium hover:underline">Sign In</a>
            </div>
        @endif
    </div>
</div>
@endsection