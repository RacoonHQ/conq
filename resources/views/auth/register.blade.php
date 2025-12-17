@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center p-4 bg-[#121212] relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#64FDDA] to-[#00D4FF]"></div>
    
    <a href="{{ route('home') }}" class="absolute top-8 left-8 text-[#A0A0A0] hover:text-white flex items-center transition-colors">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg> Back
    </a>

    <div class="w-full max-w-md bg-[#1A1A1A] rounded-2xl border border-[#333] p-8 shadow-2xl relative z-10">
        <div class="flex justify-center mb-6">
            <h1 class="text-3xl font-bold tracking-tight text-white font-['Inter']">CONQ<span class="text-[#00D4FF]">.</span></h1>
        </div>
        
        <h2 class="text-2xl font-bold text-center text-white mb-2">Create Account</h2>
        <p class="text-center text-[#A0A0A0] mb-8 text-sm">Join CONQ and unleash your creativity.</p>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-[#A0A0A0] mb-1.5 uppercase tracking-wide">Full Name</label>
                <input type="text" name="name" required class="w-full bg-[#121212] border border-[#333] rounded-lg py-2.5 px-4 text-white focus:outline-none focus:border-[#64FDDA] transition-colors text-sm">
            </div>

            <div>
                <label class="block text-xs font-medium text-[#A0A0A0] mb-1.5 uppercase tracking-wide">Email Address</label>
                <input type="email" name="email" required class="w-full bg-[#121212] border border-[#333] rounded-lg py-2.5 px-4 text-white focus:outline-none focus:border-[#64FDDA] transition-colors text-sm">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-xs font-medium text-[#A0A0A0] mb-1.5 uppercase tracking-wide">Password</label>
                <input type="password" name="password" required class="w-full bg-[#121212] border border-[#333] rounded-lg py-2.5 px-4 text-white focus:outline-none focus:border-[#64FDDA] transition-colors text-sm">
                @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full py-3 rounded-lg font-semibold text-black mt-4 bg-[#64FDDA] hover:bg-[#00D4FF] transition-colors">
                Create Account
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-[#666]">
            Already have an account? <a href="{{ route('login') }}" class="text-white font-medium hover:underline">Log In</a>
        </div>
    </div>
</div>
@endsection