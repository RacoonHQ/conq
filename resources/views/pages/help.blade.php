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

    <div class="min-h-screen bg-[#050505] text-white font-['Inter'] relative overflow-hidden flex flex-col items-center">

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

        <main class="relative z-10 px-6 pt-10 pb-20 max-w-4xl mx-auto w-full flex-grow" x-data="{ query: '' }">

            <div class="text-center mb-16 animate-fade-in-up" style="animation-duration: 0.6s;">
                <h2 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight">How can we <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-[#00D4FF] to-blue-500">help you?</span>
                </h2>

                <!-- Search Bar -->
                <div class="max-w-xl mx-auto relative group">
                    <div
                        class="absolute -inset-0.5 bg-gradient-to-r from-[#00D4FF] to-blue-500 rounded-xl opacity-30 group-hover:opacity-100 transition duration-500 blur">
                    </div>
                    <div class="relative flex items-center bg-[#050505] rounded-xl overflow-hidden">
                        <div class="pl-4 text-gray-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" x-model="query"
                            class="w-full p-4 bg-transparent text-white placeholder-gray-500 focus:outline-none"
                            placeholder="Search for answers...">
                    </div>
                </div>
            </div>

            <!-- Help Cards -->
            <div class="grid md:grid-cols-3 gap-6 mb-16 animate-fade-in-up"
                style="animation-delay: 0.2s; opacity: 0; animation-fill-mode: forwards;">
                <div
                    class="glass-card rounded-2xl p-6 text-center transition-all duration-300 transform hover:-translate-y-1 cursor-pointer group">
                    <div
                        class="w-14 h-14 bg-[#00D4FF]/10 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">Documentation</h3>
                    <p class="text-sm text-gray-400">Detailed guides on how to use all features of CONQ.</p>
                </div>

                <div
                    class="glass-card rounded-2xl p-6 text-center transition-all duration-300 transform hover:-translate-y-1 cursor-pointer group">
                    <div
                        class="w-14 h-14 bg-purple-500/10 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">Community Forum</h3>
                    <p class="text-sm text-gray-400">Connect with other users and share your experiences.</p>
                </div>

                <div
                    class="glass-card rounded-2xl p-6 text-center transition-all duration-300 transform hover:-translate-y-1 cursor-pointer group">
                    <div
                        class="w-14 h-14 bg-green-500/10 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-7 h-7 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-white">Contact Support</h3>
                    <p class="text-sm text-gray-400">Get help from our support team directly.</p>
                </div>
            </div>

            <!-- FAQ Section -->
            <div class="animate-fade-in-up" style="animation-delay: 0.4s; opacity: 0; animation-fill-mode: forwards;">
                <h3 class="text-2xl font-bold mb-8 pl-2">Frequently Asked Questions</h3>

                <div class="space-y-4">
                    @php
                        $faqs = [
                            ['q' => 'How do I switch agents?', 'a' => 'Use the dropdown menu in the chat input area to select different AI agents like Thinking AI, Code AI, Reasoning AI, or Math AI.'],
                            ['q' => 'Is my data private?', 'a' => 'Yes, all conversations are stored securely and are never shared with third parties. Your privacy is our top priority.'],
                            ['q' => 'What payment methods do you accept?', 'a' => 'We accept all major credit cards, debit cards, and PayPal. All payments are processed securely through Stripe.'],
                            ['q' => 'Can I cancel my subscription anytime?', 'a' => 'Yes, you can cancel your Pro subscription at any time. Your access will continue until the end of your billing period.'],
                            ['q' => 'How do I upgrade my plan?', 'a' => 'Visit the pricing page and click "Upgrade to Pro" or contact our sales team for Enterprise plans.'],
                            ['q' => 'Is there a free trial for Pro features?', 'a' => 'Yes, new users get a 7-day free trial of Pro features to explore all premium capabilities.'],
                            ['q' => "What's the difference between agents?", 'a' => 'Each AI agent specializes in different areas: Thinking AI for general reasoning, Code AI for programming, Reasoning AI for complex logic, and Math AI for mathematical problems.'],
                            ['q' => 'How do I export my conversations?', 'a' => 'You can export your conversations from the dashboard in various formats including PDF, JSON, or plain text.'],
                        ];
                    @endphp

                    @foreach($faqs as $faq)
                        <div class="glass-card rounded-xl p-6 transition-all duration-300"
                            x-show="!query || $el.textContent.toLowerCase().includes(query.toLowerCase())"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform scale-95"
                            x-transition:enter-end="opacity-100 transform scale-100"
                            x-transition:leave="transition ease-in duration-200"
                            x-transition:leave-start="opacity-100 transform scale-100"
                            x-transition:leave-end="opacity-0 transform scale-95">
                            <h4 class="font-semibold text-white mb-2 text-lg">{{ $faq['q'] }}</h4>
                            <p class="text-gray-400 text-sm leading-relaxed">{{ $faq['a'] }}</p>
                        </div>
                    @endforeach

                    <div x-show="query && $el.parentElement.querySelectorAll('div[x-show]:not([style*=\'display: none\'])').length === 0"
                        class="text-center py-12 text-gray-500" style="display: none;">
                        <p>No results found for "<span x-text="query"></span>"</p>
                    </div>
                </div>
            </div>
        </main>

        <footer class="py-8 text-center text-gray-600 text-sm relative z-10">
            &copy; 2025 CONQ Platform. All rights reserved.
        </footer>
    </div>
@endsection