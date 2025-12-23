@extends('layouts.app')

@extends('layouts.app')

@section('content')
    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 40px, 0);
            }

            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        .animate-fade-in-up {
            animation-name: fadeInUp;
            animation-duration: 0.8s;
            animation-fill-mode: both;
        }
    </style>

    <div
        class="min-h-screen bg-[#050505] text-white font-['Inter'] relative overflow-hidden flex flex-col items-center justify-center p-4">

        <!-- Dynamic Background -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div
                class="absolute top-0 left-1/4 w-96 h-96 bg-[#00D4FF] rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob">
            </div>
            <div
                class="absolute top-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-8 left-1/3 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob animation-delay-4000">
            </div>
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        </div>

        <!-- Back Button -->
        <a href="{{ route('login') }}"
            class="absolute top-8 left-8 group flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors z-20">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Login
        </a>

        <!-- Reset Password Card -->
        <div
            class="w-full max-w-md glass-card rounded-3xl p-8 md:p-10 relative z-10 animate-fade-in-up shadow-[0_0_40px_rgba(0,0,0,0.5)]">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}"
                    class="inline-block mb-6 text-3xl font-bold tracking-tight hover:opacity-80 transition-opacity">
                    CONQ<span class="text-[#00D4FF]">.</span>
                </a>
                <h2 class="text-2xl font-bold text-white mb-2">Reset Password</h2>
            </div>

            @if (session('status'))
                <div class="text-center animate-fade-in-up">
                    <div class="bg-[#00D4FF]/10 border border-[#00D4FF]/20 p-6 rounded-2xl mb-6">
                        <svg class="w-12 h-12 text-[#00D4FF] mx-auto mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p class="text-sm text-gray-200 font-medium">{{ session('status') }}</p>
                    </div>
                    <p class="text-xs text-gray-400 mb-6">Check your inbox and spam folder for the reset link.</p>
                    <a href="{{ route('login') }}"
                        class="block w-full py-4 rounded-xl font-bold text-black bg-[#00D4FF] hover:bg-[#64FDDA] transition-all duration-300 transform active:scale-95 text-center text-sm uppercase tracking-wide shadow-[0_0_20px_rgba(0,212,255,0.3)]">
                        Return to Login
                    </a>
                </div>
            @else
                <p class="text-center text-gray-400 mb-8 text-sm leading-relaxed">
                    Enter your email address and we'll send you instructions to reset your password.
                </p>

                <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Email
                            Address</label>
                        <div class="relative group">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-500 group-focus-within:text-[#00D4FF] transition-colors"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </div>
                            <input type="email" name="email" required
                                class="w-full bg-black/40 border border-[#333] rounded-xl py-3.5 pl-11 pr-4 text-white placeholder-gray-600 focus:outline-none focus:border-[#00D4FF] focus:ring-1 focus:ring-[#00D4FF] transition-all duration-300"
                                placeholder="name@example.com">
                        </div>
                        @error('email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit"
                        class="w-full py-4 rounded-xl font-bold text-white bg-gradient-to-r from-[#00D4FF] to-blue-500 hover:shadow-[0_0_30px_rgba(0,212,255,0.4)] transition-all duration-300 transform active:scale-95 text-sm uppercase tracking-wide">
                        Send Reset Link
                    </button>
                </form>

                <div class="mt-8 text-center">
                    <p class="text-gray-400 text-sm">
                        Remember your password?
                        <a href="{{ route('login') }}"
                            class="text-[#00D4FF] font-semibold hover:text-white transition-colors ml-1">Sign In</a>
                    </p>
                </div>
            @endif
        </div>
    </div>
@endsection