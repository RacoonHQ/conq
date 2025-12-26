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
        class="min-h-screen bg-[#050505] text-white font-['Inter'] relative flex flex-col items-center justify-center md:py-12 px-4 overflow-hidden">

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
        <div
            class="w-full max-w-md mb-4 md:mb-4 animate-fade-in-up md:block absolute md:relative top-4 md:top-auto left-4 md:left-auto">
            <a href="{{ route('home') }}"
                class="group inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors z-20">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Home
            </a>
        </div>

        <!-- Register Card -->
        <div
            class="w-full max-w-md glass-card rounded-3xl p-8 md:p-10 relative z-10 animate-fade-in-up shadow-[0_0_40px_rgba(0,0,0,0.5)]">
            <div class="text-center mb-10">
                <a href="{{ route('home') }}"
                    class="inline-block mb-6 text-3xl font-bold tracking-tight hover:opacity-80 transition-opacity">
                    CONQ<span class="text-[#00D4FF]">.</span>
                </a>
                <h2 class="text-2xl font-bold text-white mb-2">Create Account</h2>
                <p class="text-gray-400 text-sm">Join CONQ and unleash your creativity.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Full Name</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-500 group-focus-within:text-[#00D4FF] transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <input type="text" name="name" required
                            class="w-full bg-black/40 border border-[#333] rounded-xl py-3.5 pl-11 pr-4 text-white placeholder-gray-600 focus:outline-none focus:border-[#00D4FF] focus:ring-1 focus:ring-[#00D4FF] transition-all duration-300"
                            placeholder="John Doe">
                    </div>
                </div>

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

                <div x-data="{ showPassword: false }">
                    <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wider">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-500 group-focus-within:text-[#00D4FF] transition-colors"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input :type="showPassword ? 'text' : 'password'" name="password" required
                            class="w-full bg-black/40 border border-[#333] rounded-xl py-3.5 pl-11 pr-12 text-white placeholder-gray-600 focus:outline-none focus:border-[#00D4FF] focus:ring-1 focus:ring-[#00D4FF] transition-all duration-300"
                            placeholder="Min. 8 characters">
                        <button type="button" @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-white transition-colors focus:outline-none">
                            <svg x-show="!showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg x-show="showPassword" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                </div>

                <button type="submit"
                    class="w-full py-4 rounded-xl font-bold text-white bg-gradient-to-r from-[#00D4FF] to-blue-500 hover:shadow-[0_0_30px_rgba(0,212,255,0.4)] transition-all duration-300 transform active:scale-95 text-sm uppercase tracking-wide">
                    Create Account
                </button>
            </form>

            <div class="mt-8 text-center">
                <p class="text-gray-400 text-sm">
                    Already have an account?
                    <a href="{{ route('login') }}"
                        class="text-[#00D4FF] font-semibold hover:text-white transition-colors ml-1">Log In</a>
                </p>
            </div>
        </div>
    </div>
@endsection