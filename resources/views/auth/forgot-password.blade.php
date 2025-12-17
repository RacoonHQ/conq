@extends('layouts.app')

@section('content')
<div class="min-h-screen flex flex-col items-center justify-center p-4 bg-[#121212]">
    <div class="w-full max-w-md bg-[#1A1A1A] rounded-2xl border border-[#333] p-8 shadow-2xl">
        <a href="{{ route('login') }}" class="text-[#A0A0A0] hover:text-white flex items-center transition-colors mb-6 text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg> 
            Back to Login
        </a>

        <div class="flex justify-center mb-6">
            <div class="w-12 h-12 rounded-full bg-[#121212] border border-[#333] flex items-center justify-center">
                <svg class="w-6 h-6 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11.536 19.464a1.962 1.962 0 01-.949.586l-3.268.817.817-3.268a1.962 1.962 0 01.586-.949l6.086-6.666a6 6 0 013.918-3.001zM12 2.25a.75.75 0 01.75.75v2.25a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM8.788 3.468a.75.75 0 010 1.062l-1.591 1.591a.75.75 0 11-1.061-1.061l1.59-1.591a.75.75 0 011.062 0zM3.468 8.788a.75.75 0 011.062 0l1.591 1.591a.75.75 0 11-1.061 1.061l-1.59-1.591a.75.75 0 010-1.062zM3 12a.75.75 0 01.75-.75h2.25a.75.75 0 010 1.5H3.75A.75.75 0 013 12zM3.468 15.212a.75.75 0 010 1.062l1.591 1.591a.75.75 0 11-1.061-1.061l-1.59-1.591a.75.75 0 011.062 0z"/></svg>
            </div>
        </div>
        
        <h2 class="text-2xl font-bold text-center text-white mb-2">Reset Password</h2>
        
        @if (session('status'))
            <div class="text-center animate-pulse">
                <div class="bg-[#121212] border border-[#00D4FF]/30 p-4 rounded-lg mb-6">
                    <p class="text-sm text-[#E0E0E0]">{{ session('status') }}</p>
                </div>
                <p class="text-xs text-[#666] mb-6">Check your inbox and spam folder.</p>
                <a href="{{ route('login') }}" class="block w-full py-3 rounded-lg font-semibold text-[#00D4FF] border border-[#00D4FF]/30 hover:bg-[#00D4FF]/10 mt-2 transition-colors text-center">
                    Back to Login
                </a>
            </div>
        @else
            <p class="text-center text-[#A0A0A0] mb-8 text-sm">Enter your email address and we'll send you instructions to reset your password.</p>
            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-medium text-[#A0A0A0] mb-1.5 uppercase tracking-wide">Email Address</label>
                    <input type="email" name="email" required class="w-full bg-[#121212] border border-[#333] rounded-lg py-2.5 px-4 text-white focus:outline-none focus:border-[#00D4FF] transition-colors text-sm">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="w-full py-3 rounded-lg font-semibold text-black mt-2 bg-[#00D4FF] hover:bg-[#64FDDA] transition-colors">
                    Send Instructions
                </button>
            </form>
        @endif
    </div>
</div>
@endsection