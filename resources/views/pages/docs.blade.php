@extends('layouts.app')

@section('content')
    <style>
        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slide-in-left {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out forwards;
        }

        .animate-slide-in-left {
            animation: slide-in-left 0.5s ease-out forwards;
        }

        .delay-100 {
            animation-delay: 100ms;
        }

        .delay-200 {
            animation-delay: 200ms;
        }

        .delay-300 {
            animation-delay: 300ms;
        }

        .glass-card {
            background: rgba(30, 30, 30, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .glass-header {
            background: rgba(18, 18, 18, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #121212;
        }

        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #444;
        }
    </style>

    <div class="min-h-screen bg-[#121212] text-[#E0E0E0] font-['Inter'] selection:bg-[#00D4FF] selection:text-black">
        <!-- Header -->
        <header class="fixed top-0 left-0 right-0 z-50 glass-header transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight group flex items-center gap-2">
                    <span
                        class="bg-gradient-to-r from-white to-gray-400 bg-clip-text text-transparent group-hover:to-white transition-all duration-300">CONQ</span>
                    <span class="text-[#00D4FF] animate-pulse">.</span>
                </a>
                <a href="{{ route('home') }}"
                    class="group flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
                    <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Back to Home
                </a>
            </div>
        </header>

        <div class="max-w-7xl mx-auto px-6 pt-28 pb-20 flex gap-12">
            <!-- Sidebar Navigation -->
            <aside class="w-64 fixed hidden md:block overflow-y-auto h-[calc(100vh-8rem)] animate-slide-in-left">
                <div class="space-y-8 pr-4">
                    <div>
                        <div
                            class="text-xs font-bold text-[#00D4FF] uppercase tracking-widest mb-4 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#00D4FF]"></span>
                            Getting Started
                        </div>
                        <div class="space-y-1 pl-3 border-l border-white/5">
                            <a href="#intro"
                                class="group flex items-center text-sm py-2 px-3 rounded-r-lg border-l-2 border-transparent hover:bg-white/5 hover:border-[#00D4FF] text-white font-medium transition-all duration-200">
                                Introduction
                            </a>
                            <a href="#auth"
                                class="group flex items-center text-sm py-2 px-3 rounded-r-lg border-l-2 border-transparent hover:bg-white/5 hover:border-[#00D4FF] text-gray-400 hover:text-gray-200 transition-all duration-200">
                                Authentication
                            </a>
                        </div>
                    </div>

                    <div>
                        <div
                            class="text-xs font-bold text-[#00D4FF] uppercase tracking-widest mb-4 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#00D4FF]"></span>
                            Platform
                        </div>
                        <div class="space-y-1 pl-3 border-l border-white/5">
                            <a href="#dashboard"
                                class="group flex items-center text-sm py-2 px-3 rounded-r-lg border-l-2 border-transparent hover:bg-white/5 hover:border-[#00D4FF] text-gray-400 hover:text-gray-200 transition-all duration-200">
                                Dashboard
                            </a>
                            <a href="#chat"
                                class="group flex items-center text-sm py-2 px-3 rounded-r-lg border-l-2 border-transparent hover:bg-white/5 hover:border-[#00D4FF] text-gray-400 hover:text-gray-200 transition-all duration-200">
                                Chat Features
                            </a>
                            <a href="#agents"
                                class="group flex items-center text-sm py-2 px-3 rounded-r-lg border-l-2 border-transparent hover:bg-white/5 hover:border-[#00D4FF] text-gray-400 hover:text-gray-200 transition-all duration-200">
                                AI Agents
                            </a>
                        </div>
                    </div>

                    <div>
                        <div
                            class="text-xs font-bold text-[#00D4FF] uppercase tracking-widest mb-4 flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-[#00D4FF]"></span>
                            Reference
                        </div>
                        <div class="space-y-1 pl-3 border-l border-white/5">
                            <a href="#guest-vs-user"
                                class="group flex items-center text-sm py-2 px-3 rounded-r-lg border-l-2 border-transparent hover:bg-white/5 hover:border-[#00D4FF] text-gray-400 hover:text-gray-200 transition-all duration-200">
                                Guest vs User
                            </a>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="md:ml-72 flex-1 min-w-0">
                <!-- Introduction Section -->
                <section id="intro" class="mb-24 scroll-mt-28 animate-fade-in text-justify">
                    <div class="relative mb-8">
                        <div class="absolute -left-8 -top-8 w-24 h-24 bg-[#00D4FF]/10 rounded-full blur-2xl"></div>
                        <h1
                            class="text-5xl font-bold mb-6 text-transparent bg-clip-text bg-gradient-to-r from-white via-gray-200 to-gray-400 relative z-10">
                            Documentation
                        </h1>
                    </div>
                    <!-- Justified text -->
                    <p class="text-lg text-gray-400 mb-10 leading-relaxed max-w-3xl text-justify">
                        Welcome to the CONQ platform documentation. This guide provides comprehensive information about our
                        multi-model AI system, helping you understand how to leverage specialized agents for coding,
                        reasoning, and creative tasks.
                    </p>

                    <div
                        class="glass-card p-6 rounded-xl border-l-4 border-l-[#00D4FF] bg-gradient-to-r from-[#00D4FF]/5 to-transparent">
                        <div class="flex items-start gap-4">
                            <div class="p-2 bg-[#00D4FF]/10 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#00D4FF]" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-[#00D4FF] font-semibold mb-1">Quick Note</div>
                                <div class="text-gray-400 text-sm leading-relaxed text-justify">
                                    CONQ is designed to be intuitive, but this documentation dives deep into specific
                                    features like voice input, session management, and the credit system to help you master
                                    the platform.
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Authentication Section -->
                <section id="auth" class="mb-24 scroll-mt-28 animate-fade-in delay-100 text-justify">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="text-[#00D4FF]/40 text-2xl font-light">#</span>
                        <h2 class="text-3xl font-bold text-white">Authentication</h2>
                    </div>

                    <p class="text-gray-400 mb-10 leading-relaxed text-justify">
                        To access the full potential of CONQ, creating an account is recommended. While Guest Mode allows
                        for quick trials, it has limitations designed to balance server resources.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
                        <div class="glass-card p-8 rounded-2xl hover:border-[#00D4FF]/30 transition-all duration-300">
                            <div
                                class="w-12 h-12 bg-[#00D4FF]/10 rounded-xl flex items-center justify-center mb-6 text-[#00D4FF]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-white">Registration</h3>
                            <p class="text-gray-400 text-sm mb-4">New users can create an account by navigating to the Sign
                                Up page.</p>
                            <ul class="space-y-3">
                                <li class="flex items-start text-sm text-gray-400">
                                    <span class="bg-gray-800 p-1 rounded mr-3 mt-0.5"><span
                                            class="block w-1.5 h-1.5 bg-[#00D4FF] rounded-full"></span></span>
                                    <div><strong class="text-gray-200">Full Name:</strong> For personalization.</div>
                                </li>
                                <li class="flex items-start text-sm text-gray-400">
                                    <span class="bg-gray-800 p-1 rounded mr-3 mt-0.5"><span
                                            class="block w-1.5 h-1.5 bg-[#00D4FF] rounded-full"></span></span>
                                    <div><strong class="text-gray-200">Email:</strong> Unique login identifier.</div>
                                </li>
                                <li class="flex items-start text-sm text-gray-400">
                                    <span class="bg-gray-800 p-1 rounded mr-3 mt-0.5"><span
                                            class="block w-1.5 h-1.5 bg-[#00D4FF] rounded-full"></span></span>
                                    <div><strong class="text-gray-200">Password:</strong> Secure credential storage.</div>
                                </li>
                            </ul>
                        </div>

                        <div class="glass-card p-8 rounded-2xl hover:border-[#00D4FF]/30 transition-all duration-300">
                            <div
                                class="w-12 h-12 bg-purple-500/10 rounded-xl flex items-center justify-center mb-6 text-purple-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-4 text-white">Login & Session</h3>
                            <p class="text-gray-400 text-sm mb-4">Secure access with persistent sessions.</p>
                            <ul class="space-y-3">
                                <li class="flex items-start text-sm text-gray-400">
                                    <span class="bg-gray-800 p-1 rounded mr-3 mt-0.5"><span
                                            class="block w-1.5 h-1.5 bg-purple-400 rounded-full"></span></span>
                                    <div>Sessions persist if "Remember Me" is active.</div>
                                </li>
                                <li class="flex items-start text-sm text-gray-400">
                                    <span class="bg-gray-800 p-1 rounded mr-3 mt-0.5"><span
                                            class="block w-1.5 h-1.5 bg-purple-400 rounded-full"></span></span>
                                    <div>Password recovery via email link.</div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="glass-card p-8 rounded-2xl relative overflow-hidden">
                        <div
                            class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-[#00D4FF]/5 to-transparent rounded-bl-full pointer-events-none">
                        </div>
                        <h3 class="text-xl font-bold mb-6 text-white relative z-10">Profile Management</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-4 relative z-10">
                            <div class="flex items-center gap-4 text-gray-400">
                                <div class="w-8 h-8 rounded-full bg-[#333] flex items-center justify-center text-[#00D4FF]">
                                    1</div>
                                <span>Update Display Name & Email</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-400">
                                <div class="w-8 h-8 rounded-full bg-[#333] flex items-center justify-center text-[#00D4FF]">
                                    2</div>
                                <span>Secure Logout</span>
                            </div>
                            <div class="flex items-center gap-4 text-gray-400 md:col-span-2 mt-2">
                                <div
                                    class="w-8 h-8 rounded-full bg-red-900/20 flex items-center justify-center text-red-500 border border-red-500/20">
                                    !</div>
                                <span><strong class="text-red-400">Danger Zone:</strong> Permanent account deletion
                                    available.</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Dashboard Section -->
                <section id="dashboard" class="mb-24 scroll-mt-28 animate-fade-in delay-200">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="text-[#00D4FF]/40 text-2xl font-light">#</span>
                        <h2 class="text-3xl font-bold text-white">Dashboard</h2>
                    </div>
                    <p class="text-gray-400 mb-10 leading-relaxed text-justify">
                        The Dashboard serves as your command center, providing real-time insights into your usage patterns
                        and the overall system health.
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="glass-card p-6 rounded-2xl md:hover:-translate-y-1 transition-all duration-300">
                            <h3 class="text-xl font-bold mb-6 text-white flex items-center">
                                <div class="p-2 bg-green-500/10 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                    </svg>
                                </div>
                                Usage Metrics
                            </h3>
                            <div class="space-y-5">
                                <div
                                    class="flex justify-between items-center p-3 rounded-lg bg-white/5 border border-white/5">
                                    <span class="text-gray-300 font-medium">Total Queries</span>
                                    <span class="text-xs text-gray-500 uppercase tracking-widest">Count</span>
                                </div>
                                <div
                                    class="flex justify-between items-center p-3 rounded-lg bg-white/5 border border-white/5">
                                    <span class="text-gray-300 font-medium">Time Saved</span>
                                    <span class="text-xs text-gray-500 uppercase tracking-widest">Est. Hours</span>
                                </div>
                                <div
                                    class="flex justify-between items-center p-3 rounded-lg bg-white/5 border border-white/5">
                                    <span class="text-gray-300 font-medium">Credits</span>
                                    <span class="text-xs text-green-400 uppercase tracking-widest">Balance</span>
                                </div>
                            </div>
                        </div>

                        <div class="glass-card p-6 rounded-2xl md:hover:-translate-y-1 transition-all duration-300">
                            <h3 class="text-xl font-bold mb-6 text-white flex items-center">
                                <div class="p-2 bg-blue-500/10 rounded-lg mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                System Status
                            </h3>
                            <div class="space-y-5">
                                <div
                                    class="flex justify-between items-center p-3 rounded-lg bg-white/5 border border-white/5">
                                    <span class="text-gray-300 font-medium">API Health</span>
                                    <div class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                                        <span class="text-xs text-gray-500">Operational</span>
                                    </div>
                                </div>
                                <div
                                    class="flex justify-between items-center p-3 rounded-lg bg-white/5 border border-white/5">
                                    <span class="text-gray-300 font-medium">Queue Status</span>
                                    <span class="text-xs text-gray-500">Real-time</span>
                                </div>
                                <div
                                    class="flex justify-between items-center p-3 rounded-lg bg-white/5 border border-white/5">
                                    <span class="text-gray-300 font-medium">Updates</span>
                                    <span class="text-xs text-gray-500">Latest v1.2</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Chat Interface Section -->
                <section id="chat" class="mb-24 scroll-mt-28 animate-fade-in delay-200">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="text-[#00D4FF]/40 text-2xl font-light">#</span>
                        <h2 class="text-3xl font-bold text-white">Chat Interface</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Feature Card 1 -->
                        <div
                            class="glass-card p-6 rounded-xl border border-white/5 hover:border-[#00D4FF]/30 transition-colors duration-300">
                            <div class="mb-4 text-[#00D4FF]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">Voice Input</h3>
                            <p class="text-gray-400 text-sm leading-relaxed mb-3 text-justify">
                                Click the microphone to record. Transcribes English audio instantly.
                            </p>
                            <span
                                class="text-[10px] uppercase font-bold text-xs bg-white/5 px-2 py-1 rounded text-gray-500">Requires
                                Login</span>
                        </div>

                        <!-- Feature Card 2 -->
                        <div
                            class="glass-card p-6 rounded-xl border border-white/5 hover:border-[#00D4FF]/30 transition-colors duration-300">
                            <div class="mb-4 text-[#00D4FF]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">File Context</h3>
                            <p class="text-gray-400 text-sm leading-relaxed mb-3 text-justify">
                                Upload PDFs, images, or text files (max 10MB) for AI analysis.
                            </p>
                            <span
                                class="text-[10px] uppercase font-bold text-xs bg-white/5 px-2 py-1 rounded text-gray-500">Requires
                                Login</span>
                        </div>

                        <!-- Feature Card 3 -->
                        <div
                            class="glass-card p-6 rounded-xl border border-white/5 hover:border-[#00D4FF]/30 transition-colors duration-300">
                            <div class="mb-4 text-[#00D4FF]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">Session History</h3>
                            <p class="text-gray-400 text-sm leading-relaxed mb-3 text-justify">
                                Searchable conversation archives. Resume past chats anytime.
                            </p>
                            <span
                                class="text-[10px] uppercase font-bold text-xs bg-white/5 px-2 py-1 rounded text-gray-500">Requires
                                Login</span>
                        </div>

                        <!-- Feature Card 4 -->
                        <div
                            class="glass-card p-6 rounded-xl border border-white/5 hover:border-[#00D4FF]/30 transition-colors duration-300">
                            <div class="mb-4 text-[#00D4FF]">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-white mb-2">Agent Switching</h3>
                            <p class="text-gray-400 text-sm leading-relaxed mb-3 text-justify">
                                Seamlessly toggle between Code, Math, and Creative agents.
                            </p>
                            <span
                                class="text-[10px] uppercase font-bold text-xs bg-teal-500/10 text-teal-400 px-2 py-1 rounded">Universal</span>
                        </div>
                    </div>
                </section>

                <!-- AI Specialists Section -->
                <section id="agents" class="mb-24 scroll-mt-28 animate-fade-in delay-300">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="text-[#00D4FF]/40 text-2xl font-light">#</span>
                        <h2 class="text-3xl font-bold text-white">AI Specialists</h2>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div
                            class="group glass-card p-1 rounded-2xl bg-gradient-to-br from-white/5 to-transparent hover:from-[#00D4FF]/20 transition-all duration-500">
                            <div class="bg-[#181818] p-6 rounded-xl h-full flex items-start gap-6">
                                <div
                                    class="flex-shrink-0 w-16 h-16 rounded-2xl bg-gradient-to-br from-purple-600 to-indigo-600 flex items-center justify-center shadow-lg shadow-purple-900/40">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="text-xl font-bold text-white mb-2 group-hover:text-[#00D4FF] transition-colors">
                                        Thinking AI</h3>
                                    <p class="text-gray-400 text-sm text-justify">A balanced model optimized for general
                                        knowledge, creative writing, brainstorming, and coherent conversation.</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="group glass-card p-1 rounded-2xl bg-gradient-to-br from-white/5 to-transparent hover:from-[#00D4FF]/20 transition-all duration-500">
                            <div class="bg-[#181818] p-6 rounded-xl h-full flex items-start gap-6">
                                <div
                                    class="flex-shrink-0 w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-600 to-cyan-600 flex items-center justify-center shadow-lg shadow-blue-900/40">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="text-xl font-bold text-white mb-2 group-hover:text-[#00D4FF] transition-colors">
                                        Code AI</h3>
                                    <p class="text-gray-400 text-sm text-justify">Engineered for software development. Can
                                        generate, debug, and explain code across multiple languages with high accuracy.</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="group glass-card p-1 rounded-2xl bg-gradient-to-br from-white/5 to-transparent hover:from-[#00D4FF]/20 transition-all duration-500">
                            <div class="bg-[#181818] p-6 rounded-xl h-full flex items-start gap-6">
                                <div
                                    class="flex-shrink-0 w-16 h-16 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-600 flex items-center justify-center shadow-lg shadow-emerald-900/40">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="text-xl font-bold text-white mb-2 group-hover:text-[#00D4FF] transition-colors">
                                        Reasoning AI</h3>
                                    <p class="text-gray-400 text-sm text-justify">Optimized for chain-of-thought processing,
                                        complex logic puzzles, and step-by-step analytical problem solving.</p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="group glass-card p-1 rounded-2xl bg-gradient-to-br from-white/5 to-transparent hover:from-[#00D4FF]/20 transition-all duration-500">
                            <div class="bg-[#181818] p-6 rounded-xl h-full flex items-start gap-6">
                                <div
                                    class="flex-shrink-0 w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-600 to-red-600 flex items-center justify-center shadow-lg shadow-orange-900/40">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.871 4A17.926 17.926 0 003 12c0 2.874.673 5.59 1.871 8m14.13 0a17.926 17.926 0 001.87-8c0-2.874-.673-5.59-1.87-8M9 9h1.246a1 1 0 01.961.727l1.586 5.55a1 1 0 00.961.727H15" />
                                    </svg>
                                </div>
                                <div>
                                    <h3
                                        class="text-xl font-bold text-white mb-2 group-hover:text-[#00D4FF] transition-colors">
                                        Math AI</h3>
                                    <p class="text-gray-400 text-sm text-justify">Specialized in computation, statistical
                                        analysis, and solving complex mathematical equations with precision.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Comparison Section -->
                <section id="guest-vs-user" class="mb-24 scroll-mt-28 animate-fade-in delay-300">
                    <div class="flex items-center gap-3 mb-8">
                        <span class="text-[#00D4FF]/40 text-2xl font-light">#</span>
                        <h2 class="text-3xl font-bold text-white">Guest vs User</h2>
                    </div>

                    <div class="glass-card rounded-2xl overflow-hidden shadow-2xl">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gradient-to-r from-gray-900 to-gray-800 border-b border-white/5">
                                        <th class="p-6 font-semibold text-gray-300">Feature</th>
                                        <th class="p-6 font-semibold text-gray-400 text-center">Guest Mode</th>
                                        <th class="p-6 font-semibold text-[#00D4FF] text-center">Registered User</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-white/5">
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="p-5 text-gray-300">Chat History</td>
                                        <td class="p-5 text-center text-red-500/50">
                                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </td>
                                        <td class="p-5 text-center text-[#00D4FF]">
                                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="p-5 text-gray-300">Usage Limit</td>
                                        <td class="p-5 text-center text-gray-500 text-sm">3 Queries / Session</td>
                                        <td class="p-5 text-center text-[#00D4FF] font-medium text-sm">100 Credits
                                            (Refillable)</td>
                                    </tr>
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="p-5 text-gray-300">File Uploads</td>
                                        <td class="p-5 text-center text-red-500/50">
                                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </td>
                                        <td class="p-5 text-center text-[#00D4FF]">
                                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="p-5 text-gray-300">Voice Input</td>
                                        <td class="p-5 text-center text-red-500/50">
                                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </td>
                                        <td class="p-5 text-center text-[#00D4FF]">
                                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </td>
                                    </tr>
                                    <tr class="hover:bg-white/5 transition-colors">
                                        <td class="p-5 text-gray-300">Adv. Agents</td>
                                        <td class="p-5 text-center text-yellow-500/80 text-sm">Limited Access</td>
                                        <td class="p-5 text-center text-[#00D4FF]">
                                            <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div
                        class="mt-12 bg-gradient-to-r from-blue-900/40 to-blue-800/10 border-l-4 border-blue-500 p-6 rounded-r-xl backdrop-blur-sm">
                        <div class="flex items-start gap-4">
                            <div class="p-2 bg-blue-500/20 rounded-lg shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-blue-400 font-bold mb-2">Recommendation</h4>
                                <p class="text-gray-300 text-sm text-justify">
                                    For the best experience, we strongly recommend creating an account. It unlocks the
                                    platform's full memory, allowing you to build upon previous conversations and access
                                    powerful multimodal features.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

            </main>
        </div>
    </div>
@endsection