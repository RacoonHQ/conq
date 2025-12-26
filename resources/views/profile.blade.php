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
            backdrop-filter: blur(20px);
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
        class="min-h-screen bg-[#050505] text-white font-['Inter'] relative overflow-hidden flex flex-col items-center pt-20 px-4">

        <!-- Dynamic Background -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div
                class="absolute top-0 left-1/4 w-96 h-96 bg-[#00D4FF] rounded-full mix-blend-multiply filter blur-[128px] opacity-10 animate-blob">
            </div>
            <div
                class="absolute top-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-10 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-8 left-1/3 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-10 animate-blob animation-delay-4000">
            </div>
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        </div>

        <div class="w-full max-w-2xl relative z-10 animate-fade-in-up">
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('chat.index') }}"
                    class="group flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-all duration-300">
                    <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                        </path>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold tracking-tight">Profile</h1>
            </div>

            <div class="glass-card rounded-[32px] overflow-hidden shadow-[0_0_50px_rgba(0,0,0,0.5)]"
                x-data="{ editing: false }">
                <!-- Cover Area -->
                <div
                    class="h-40 bg-gradient-to-r from-[#00D4FF]/10 via-purple-500/10 to-blue-500/10 border-b border-white/5 relative">
                    <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-10">
                    </div>
                </div>

                <div class="px-8 md:px-12 pb-12">
                    <div class="relative -mt-16 mb-8 flex justify-between items-end">
                        <div
                            class="w-32 h-32 rounded-3xl bg-[#050505] p-1.5 border border-white/10 shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-500">
                            <div
                                class="w-full h-full rounded-2xl bg-gradient-to-br from-[#00D4FF] to-blue-600 flex items-center justify-center text-black font-black text-4xl shadow-lg">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                        </div>
                        <button @click="editing = !editing"
                            class="px-6 py-3 rounded-xl text-sm font-bold transition-all flex items-center shadow-lg transform active:scale-95"
                            :class="editing ? 'bg-white/5 text-white hover:bg-white/10 border border-white/10' : 'bg-gradient-to-r from-[#00D4FF] to-blue-500 text-black hover:shadow-[0_0_20px_rgba(0,212,255,0.4)]'">
                            <span x-text="editing ? 'Cancel' : 'Edit Profile'"></span>
                        </button>
                    </div>

                    <form method="POST" action="{{ route('profile.update') }}" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] ml-1">Display
                                    Name</label>
                                <div class="relative group">
                                    <input type="text" name="name" value="{{ $user->name }}" :disabled="!editing"
                                        class="w-full bg-black/40 border border-white/5 rounded-2xl py-4 px-5 text-white focus:outline-none focus:border-[#00D4FF]/50 transition-all font-medium text-[15px]"
                                        :class="editing ? 'bg-black/60 border-white/20' : 'cursor-not-allowed'">
                                    <template x-if="editing">
                                        <div
                                            class="absolute inset-0 rounded-2xl bg-[#00D4FF]/5 pointer-events-none opacity-0 group-focus-within:opacity-100 transition-opacity">
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label
                                    class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] ml-1">Email
                                    Address</label>
                                <div class="relative group">
                                    <input type="email" name="email" value="{{ $user->email }}" :disabled="!editing"
                                        class="w-full bg-black/40 border border-white/5 rounded-2xl py-4 px-5 text-white focus:outline-none focus:border-[#00D4FF]/50 transition-all font-medium text-[15px]"
                                        :class="editing ? 'bg-black/60 border-white/20' : 'cursor-not-allowed'">
                                    <template x-if="editing">
                                        <div
                                            class="absolute inset-0 rounded-2xl bg-[#00D4FF]/5 pointer-events-none opacity-0 group-focus-within:opacity-100 transition-opacity">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div x-show="editing" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0" class="flex justify-end">
                            <button type="submit"
                                class="bg-[#00D4FF] text-black px-8 py-3 rounded-xl font-bold hover:bg-[#33E0FF] transition-all shadow-lg hover:shadow-[0_0_25px_rgba(0,212,255,0.3)] transform active:scale-95">
                                Save Changes
                            </button>
                        </div>
                    </form>

                    <div class="pt-10 border-t border-white/5 mt-10">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-sm font-bold text-white mb-1">Account Security</h4>
                                <p class="text-xs text-gray-500">Manage your session and security preferences.</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="group flex items-center gap-2 text-xs font-bold text-red-400 hover:text-red-300 border border-red-500/20 px-5 py-2.5 rounded-xl hover:bg-red-500/5 transition-all">
                                    <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection