@extends('layouts.app')

@section('content')
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob { animation: blob 7s infinite; }
        .animation-delay-2000 { animation-delay: 2s; }
        .animation-delay-4000 { animation-delay: 4s; }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>

    <div class="min-h-screen bg-[#050505] text-white font-['Inter'] relative overflow-hidden flex flex-col items-center">
        <!-- Dynamic Background -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-[#00D4FF] rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob"></div>
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-1/3 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        </div>

        <header class="relative z-10 w-full px-6 py-6 max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight hover:opacity-80 transition-opacity">CONQ<span class="text-[#00D4FF]">.</span></a>
            <a href="{{ route('dashboard') }}" class="group flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Dashboard
            </a>
        </header>

        <main class="relative z-10 px-6 pt-10 pb-20 max-w-4xl mx-auto w-full flex-grow">
            <div class="text-center mb-12">
                <h1 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight">Manage Subscription</h1>
                <p class="text-xl text-gray-400 max-w-2xl mx-auto">View and manage your current plan details.</p>
            </div>

            <div class="glass-card rounded-2xl p-8 relative overflow-hidden">
            <!-- Cyan Glow for Active Status -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-[#00D4FF] rounded-full mix-blend-multiply filter blur-[80px] opacity-10 pointer-events-none"></div>

            <div class="flex items-start justify-between mb-8 relative z-10">
                <div>
                    <h2 class="text-2xl font-bold text-white mb-2">Current Plan: Pro</h2>
                    <p class="text-gray-400">Unlock full power with unlimited queries and advanced AI models.</p>
                </div>
                <div class="px-4 py-2 bg-[#00D4FF]/10 border border-[#00D4FF]/20 rounded-full flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-[#00D4FF]"></span>
                    <span class="text-[#00D4FF] text-sm font-semibold">Active</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 relative z-10">
                <div class="p-6 bg-black/40 rounded-xl border border-white/5">
                    <div class="text-gray-400 text-sm mb-1 uppercase tracking-wider">Billing Cycle</div>
                    <div class="text-xl font-semibold text-white">Monthly</div>
                </div>
                <div class="p-6 bg-black/40 rounded-xl border border-white/5">
                    <div class="text-gray-400 text-sm mb-1 uppercase tracking-wider">Next Payment</div>
                    <!-- Tanggal expire dari database -->
                    <div class="text-xl font-semibold text-white">{{ $user->subscription_expires_at ? $user->subscription_expires_at->format('F d, Y') : 'N/A' }}</div>
                </div>
                <div class="p-6 bg-black/40 rounded-xl border border-white/5">
                    <div class="text-gray-400 text-sm mb-1 uppercase tracking-wider">Amount</div>
                    <div class="text-xl font-semibold text-white">$19.00</div>
                </div>
                <div class="p-6 bg-black/40 rounded-xl border border-white/5">
                    <div class="text-gray-400 text-sm mb-1 uppercase tracking-wider">Payment Method</div>
                    <div class="text-xl font-semibold text-white flex items-center gap-2">
                        <svg class="w-6 h-6 text-gray-300" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20 4H4c-1.11 0-1.99.89-1.99 2L2 18c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V6c0-1.11-.89-2-2-2zm0 14H4v-6h16v6zm0-10H4V6h16v2z"/>
                        </svg>
                        •••• 4242
                    </div>
                </div>
            </div>

            <div class="border-t border-white/10 pt-8 flex justify-end relative z-10">
                <a href="{{ route('subscription.checkout') }}" class="px-6 py-3 rounded-lg font-bold text-black bg-[#00D4FF] hover:bg-[#00c2ea] transition-colors text-center">
                    Extend Subscription
                </a>
            </div>
        </div>
    </main>
</div>
@endsection
