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

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(0, 212, 255, 0.3);
            box-shadow: 0 0 30px rgba(0, 212, 255, 0.1);
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

    <div x-data="{ open: false }"
        class="min-h-screen bg-[#050505] text-white font-['Inter'] relative overflow-hidden flex flex-col items-center">

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

        <header class="relative z-10 w-full px-6 py-6 max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight hover:opacity-80 transition-opacity">
                CONQ<span class="text-[#00D4FF]">.</span>
            </a>
            <a href="{{ route('home') }}"
                class="group flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Home
            </a>
        </header>

        <main class="relative z-10 px-6 pt-10 pb-20 max-w-7xl mx-auto w-full flex-grow">
            <div class="text-center mb-20">
                <h2 class="text-5xl md:text-6xl font-bold mb-6 tracking-tight animate-fade-in-up"
                    style="animation-duration: 0.6s;">
                    Simple pricing, <br class="md:hidden" />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00D4FF] to-blue-500">powerful</span>
                    results
                </h2>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto animate-fade-in-up"
                    style="animation-duration: 0.8s; opacity: 0; animation-fill-mode: forwards; animation-delay: 0.2s;">
                    Choose the plan that best fits your needs. Upgrade or downgrade at any time.
                </p>
            </div>

            <!-- Pricing Plans -->
            <!-- Pricing Plans -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Starter Plan -->
                <div class="glass-card rounded-3xl p-8 transition-all duration-300 transform hover:-translate-y-2 relative group animate-fade-in-up flex flex-col h-full"
                    style="animation-delay: 0.3s; opacity: 0; animation-fill-mode: forwards;">
                    <h3 class="text-2xl font-semibold mb-2 text-gray-100">Starter</h3>
                    <div class="flex items-baseline mb-6">
                        <span class="text-4xl font-bold text-white">Free</span>
                    </div>
                    <p class="text-gray-400 text-sm mb-8">Perfect for exploring and light usage.</p>

                    <ul class="space-y-4 mb-8 flex-grow">
                        @foreach(['Access to Thinking AI', 'Access to Code AI', 'Limited queries per day', 'Standard response speed', 'Community support'] as $feature)
                            <li class="flex items-start gap-3">
                                <div class="p-1 rounded-full bg-white/5 border border-white/10 mt-0.5">
                                    <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-gray-300 text-sm">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <a href="{{ Auth::check() ? route('dashboard') : route('login') }}"
                        class="w-full py-4 rounded-xl font-semibold text-sm bg-white/5 text-white hover:bg-white/10 border border-white/10 transition-all duration-200 text-center block active:scale-95 group-hover:border-white/20 mt-auto">
                        Get Started
                    </a>
                </div>

                <!-- Pro Plan -->
                <div class="glass-card rounded-3xl p-8 transition-all duration-300 transform hover:-translate-y-2 relative border-[#00D4FF]/30 hover:border-[#00D4FF]/80 shadow-[0_0_40px_rgba(0,212,255,0.05)] animate-fade-in-up md:-mt-8 flex flex-col h-full md:mb-8"
                    style="animation-delay: 0.4s; opacity: 0; animation-fill-mode: forwards;">
                    <div
                        class="absolute -top-4 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-[#00D4FF] to-blue-500 text-black text-xs font-bold px-4 py-1.5 rounded-full shadow-[0_0_20px_rgba(0,212,255,0.4)] tracking-wide">
                        MOST POPULAR
                    </div>
                    <h3 class="text-2xl font-semibold mb-2 text-white">Pro</h3>
                    <div class="flex items-baseline mb-6">
                        <span class="text-5xl font-bold text-white">$19</span>
                        <span class="text-gray-400 ml-2 font-light">/month</span>
                    </div>
                    <p class="text-gray-300 text-sm mb-8">For professionals who need power and speed.</p>

                    <ul class="space-y-4 mb-8 flex-grow">
                        @foreach(['Everything in Starter', 'Unlimited queries', 'Access to Reasoning AI', 'Access to Math AI', 'Priority response speed', 'Early access to new features'] as $feature)
                            <li class="flex items-start gap-3">
                                <div class="p-1 rounded-full bg-[#00D4FF]/10 border border-[#00D4FF]/20 mt-0.5">
                                    <svg class="w-3 h-3 text-[#00D4FF]" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-gray-200 text-sm">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>

                    @if(Auth::check() && Auth::user()->plan === 'Pro')
                        <a href="{{ route('subscription.manage') }}"
                            class="w-full py-4 rounded-xl font-bold text-sm bg-[#00D4FF] text-black hover:bg-[#00c2ea] hover:shadow-[0_0_20px_rgba(0,212,255,0.4)] transition-all duration-200 text-center block active:scale-95 transform mt-auto">
                            Manage Subscription
                        </a>
                    @else
                        <a href="{{ route('subscription.upgrade') }}"
                            class="w-full py-4 rounded-xl font-bold text-sm bg-[#00D4FF] text-black hover:bg-[#00c2ea] hover:shadow-[0_0_20px_rgba(0,212,255,0.4)] transition-all duration-200 text-center block active:scale-95 transform mt-auto">
                            Upgrade to Pro
                        </a>
                    @endif
                </div>

                <!-- Enterprise Plan -->
                <div class="glass-card rounded-3xl p-8 transition-all duration-300 transform hover:-translate-y-2 relative group animate-fade-in-up flex flex-col h-full"
                    style="animation-delay: 0.5s; opacity: 0; animation-fill-mode: forwards;">
                    <h3 class="text-2xl font-semibold mb-2 text-gray-100">Enterprise</h3>
                    <div class="flex items-baseline mb-6">
                        <span class="text-4xl font-bold text-white">Custom</span>
                    </div>
                    <p class="text-gray-400 text-sm mb-8">For teams and organizations requiring scale.</p>

                    <ul class="space-y-4 mb-8 flex-grow">
                        @foreach(['Everything in Pro', 'Dedicated API access', 'Custom fine-tuned models', 'SSO & Advanced Security', 'Dedicated Account Manager', 'SLA Guarantees'] as $feature)
                            <li class="flex items-start gap-3">
                                <div class="p-1 rounded-full bg-white/5 border border-white/10 mt-0.5">
                                    <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-gray-300 text-sm">{{ $feature }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <button @click="open = true"
                        class="w-full py-4 rounded-xl font-semibold text-sm bg-white/5 text-white hover:bg-white/10 border border-white/10 transition-all duration-200 block text-center active:scale-95 group-hover:border-white/20 mt-auto">
                        Contact Sales
                    </button>
                </div>
            </div>

            <!-- Contact Sales Modal -->
            <!-- x-show and transitions applied here, controlled by parent scope -->
            <div @keydown.escape.window="open = false" x-show="open" style="display: none;"
                class="fixed inset-0 z-50 flex items-center justify-center p-4">

                <!-- Backdrop -->
                <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
                    class="fixed inset-0 bg-black/80 backdrop-blur-sm transition-opacity"></div>

                <!-- Modal Panel -->
                <div x-show="open" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                    class="glass-card w-full max-w-lg rounded-2xl p-8 relative shadow-2xl overflow-hidden bg-[#121212]">

                    <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#00D4FF] to-blue-600"></div>

                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold text-white">Contact Sales</h3>
                        <button @click="open = false"
                            class="text-gray-400 hover:text-white transition-colors p-2 hover:bg-white/5 rounded-lg">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form action="{{ route('subscription.contact') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Name</label>
                            <input type="text" name="name" required
                                class="w-full px-4 py-3 bg-black/40 border border-[#333] rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-[#00D4FF] focus:ring-1 focus:ring-[#00D4FF] transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                            <input type="email" name="email" required
                                class="w-full px-4 py-3 bg-black/40 border border-[#333] rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-[#00D4FF] focus:ring-1 focus:ring-[#00D4FF] transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Company (Optional)</label>
                            <input type="text" name="company"
                                class="w-full px-4 py-3 bg-black/40 border border-[#333] rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-[#00D4FF] focus:ring-1 focus:ring-[#00D4FF] transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Message</label>
                            <textarea name="message" rows="4" required
                                class="w-full px-4 py-3 bg-black/40 border border-[#333] rounded-xl text-white placeholder-gray-600 focus:outline-none focus:border-[#00D4FF] focus:ring-1 focus:ring-[#00D4FF] transition-all"></textarea>
                        </div>
                        <button type="submit"
                            class="w-full py-4 rounded-xl font-bold text-sm bg-gradient-to-r from-[#00D4FF] to-blue-500 text-white hover:shadow-[0_0_20px_rgba(0,212,255,0.4)] transition-all duration-200 transform active:scale-95">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>

        </main>
    </div>
@endsection