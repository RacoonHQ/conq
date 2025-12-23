@extends('layouts.app')

@section('content')
    <style>
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
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
            <div class="absolute top-0 left-1/4 w-96 h-96 bg-[#00D4FF] rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob"></div>
            <div class="absolute top-0 right-1/4 w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-8 left-1/3 w-96 h-96 bg-blue-500 rounded-full mix-blend-multiply filter blur-[128px] opacity-20 animate-blob animation-delay-4000"></div>
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
        </div>

        <header class="relative z-10 w-full px-6 py-6 max-w-7xl mx-auto flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight hover:opacity-80 transition-opacity">
                CONQ<span class="text-[#00D4FF]">.</span>
            </a>
            <a href="{{ route('home') }}" class="group flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
                <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Home
            </a>
        </header>

        <main class="relative z-10 px-6 pt-10 pb-20 max-w-7xl mx-auto w-full flex-grow">

            <!-- Hero Section -->
            <div class="text-center mb-20 max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-7xl font-bold mb-8 leading-tight animate-fade-in-up" style="animation-duration: 0.6s;">
                    Empowering Intelligence <br />
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#00D4FF] to-blue-500">for Everyone.</span>
                </h1>
                <p class="text-xl md:text-2xl text-gray-300 max-w-2xl mx-auto font-light animate-fade-in-up" style="animation-delay: 0.2s; opacity: 0; animation-fill-mode: forwards;">
                    CONQ is a next-generation multi-model AI platform designed to bridge the gap between complex AI capabilities and intuitive human interaction.
                </p>
            </div>

            <!-- Mission & Vision Grid -->
            <div class="grid md:grid-cols-2 gap-8 mb-24">
                <!-- Mission -->
                <div class="glass-card rounded-3xl p-8 md:p-12 transition-all duration-300 transform hover:-translate-y-2 animate-fade-in-up flex flex-col justify-between" style="animation-delay: 0.3s; opacity: 0; animation-fill-mode: forwards;">
                    <div>
                        <div class="w-12 h-12 bg-[#00D4FF]/10 rounded-xl flex items-center justify-center mb-6 text-[#00D4FF]">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold mb-4 text-white">Our Mission</h3>
                        <p class="text-gray-400 leading-relaxed text-lg">
                            We believe that the future of productivity lies in the collaboration between humans and specialized AI agents. Our mission is to provide a seamless, unified interface where users can access the best-in-class models for every specific task.
                        </p>
                    </div>
                    <div class="mt-8 pt-8 border-t border-white/5 opacity-50">
                        <span class="text-7xl font-bold text-transparent bg-clip-text bg-gradient-to-b from-white/10 to-transparent select-none">MISSION</span>
                    </div>
                </div>

                <!-- Vision -->
                <div class="glass-card rounded-3xl p-8 md:p-12 transition-all duration-300 transform hover:-translate-y-2 animate-fade-in-up flex flex-col justify-between" style="animation-delay: 0.4s; opacity: 0; animation-fill-mode: forwards;">
                    <div>
                        <div class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center mb-6 text-purple-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-3xl font-bold mb-4 text-white">Global Vision</h3>
                        <p class="text-gray-400 leading-relaxed text-lg">
                            Our vision extends beyond just providing AI tools. We aim to create a global ecosystem where businesses, developers, and everyday users can harness the power of multiple AI models through a single, intuitive platform to democratize access.
                        </p>
                    </div>
                    <div class="mt-8 pt-8 border-t border-white/5 opacity-50">
                        <span class="text-7xl font-bold text-transparent bg-clip-text bg-gradient-to-b from-white/10 to-transparent select-none">VISION</span>
                    </div>
                </div>
            </div>

            <!-- Team Section -->
            <div class="mb-12 animate-fade-in-up" style="animation-delay: 0.5s; opacity: 0; animation-fill-mode: forwards;">
                <h3 class="text-3xl md:text-4xl font-bold mb-12 text-center">Meet the Team</h3>
                <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach([
                            ['name' => 'Sayyid Abdullah Azzam', 'role' => 'Co-founder & CEO', 'color' => 'bg-blue-500/10'],
                            ['name' => 'Andreas Rio Christian', 'role' => 'Co-founder & CTO', 'color' => 'bg-purple-500/10'],
                            ['name' => 'Linus Torvalds', 'role' => 'Co-founder & CPO', 'color' => 'bg-green-500/10'],
                            ['name' => 'Mark Zuckerberg', 'role' => 'Co-founder & CMO', 'color' => 'bg-orange-500/10']
                        ] as $index => $member)
                        <div class="glass-card rounded-2xl p-6 text-center transition-all duration-300 hover:scale-105 group relative overflow-hidden" 
                             style="animation-delay: {{ 0.6 + ($index * 0.1) }}s;">

                            <div class="absolute inset-0 bg-gradient-to-b from-transparent to-black/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>

                            <div class="{{ $member['color'] }} rounded-full w-24 h-24 mx-auto mb-6 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <h4 class="text-xl font-bold mb-2 text-white">{{ $member['name'] }}</h4>
                            <p class="text-sm font-medium text-[#00D4FF]">{{ $member['role'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>

        <footer class="py-8 text-center text-gray-600 text-sm relative z-10">
            &copy; 2025 CONQ Platform. All rights reserved.
        </footer>
    </div>
@endsection