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

        .stagger-1 {
            animation-delay: 0.1s;
        }

        .stagger-2 {
            animation-delay: 0.2s;
        }

        .stagger-3 {
            animation-delay: 0.3s;
        }

        .stagger-4 {
            animation-delay: 0.4s;
        }

        .stagger-5 {
            animation-delay: 0.5s;
        }
    </style>

    <div class="min-h-screen bg-[#050505] text-white font-['Inter'] relative overflow-hidden">
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

        <!-- Header -->
        <header class="relative z-10 glass-card border-b border-white/5">
            <div class="max-w-6xl mx-auto px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('chat.index') }}"
                        class="group flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-all duration-300">
                        <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                            </path>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold tracking-tight">Dashboard</h1>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-sm text-gray-400">{{ $user->name }}</div>
                    <div
                        class="w-10 h-10 rounded-full bg-gradient-to-br from-[#00D4FF] to-blue-500 flex items-center justify-center text-black font-bold text-sm shadow-lg">
                        {{ substr($user->name, 0, 2) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="relative z-10 max-w-6xl mx-auto px-6 py-10">
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
                <!-- Total Queries Card -->
                <div
                    class="glass-card rounded-2xl p-6 animate-fade-in-up stagger-1 hover:shadow-[0_0_30px_rgba(0,212,255,0.2)] transition-all duration-300 group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="text-gray-400 text-xs uppercase tracking-wider mb-2 font-semibold">Total Queries
                            </div>
                            <div class="text-4xl font-bold text-white mb-1 group-hover:text-[#00D4FF] transition-colors">
                                {{ $totalQueries }}
                            </div>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-[#00D4FF]/10 flex items-center justify-center group-hover:bg-[#00D4FF]/20 transition-colors">
                            <svg class="w-6 h-6 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Time Saved Card -->
                <div
                    class="glass-card rounded-2xl p-6 animate-fade-in-up stagger-2 hover:shadow-[0_0_30px_rgba(168,85,247,0.2)] transition-all duration-300 group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="text-gray-400 text-xs uppercase tracking-wider mb-2 font-semibold">Time Saved
                            </div>
                            <div class="text-4xl font-bold text-white mb-1 group-hover:text-purple-400 transition-colors">
                                {{ $timeSaved }}<span class="text-2xl">h</span>
                            </div>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-purple-500/10 flex items-center justify-center group-hover:bg-purple-500/20 transition-colors">
                            <svg class="w-6 h-6 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Credits Card -->
                <div
                    class="glass-card rounded-2xl p-6 animate-fade-in-up stagger-3 hover:shadow-[0_0_30px_rgba(59,130,246,0.2)] transition-all duration-300 group">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <div class="text-gray-400 text-xs uppercase tracking-wider mb-2 font-semibold">Credits</div>
                            <div class="text-4xl font-bold text-white mb-1 group-hover:text-blue-400 transition-colors"
                                x-data="{ credits: {{ $remainingCredits }} }" x-text="credits"></div>
                            <div class="text-xs text-gray-500 mt-1">5 credits per prompt (resets daily)</div>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center group-hover:bg-blue-500/20 transition-colors">
                            <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bottom Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Conversations -->
                <div class="glass-card rounded-2xl p-6 animate-fade-in-up stagger-4">
                    <h3 class="text-lg font-semibold mb-6 flex items-center justify-between">
                        <span class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Recent Conversations
                        </span>
                        <button onclick="showDeleteConfirm()"
                            class="text-red-400 hover:text-red-300 text-sm font-medium transition-colors">Delete
                            All</button>
                    </h3>
                    <div class="space-y-3">
                        @forelse($history->take(5) as $item)
                            <div
                                class="flex items-center justify-between p-4 rounded-xl bg-black/20 hover:bg-black/40 transition-all duration-300 cursor-pointer border border-white/5 hover:border-[#00D4FF]/30 group">
                                <div class="flex-1">
                                    <div
                                        class="text-sm font-medium text-white mb-1 group-hover:text-[#00D4FF] transition-colors">
                                        {{ $item->title }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $item->agent_id }}</div>
                                </div>
                                <div class="text-xs text-gray-600">{{ $item->created_at->format('M d') }}</div>
                            </div>
                        @empty
                            <div class="text-center py-12">
                                <svg class="w-16 h-16 text-gray-700 mx-auto mb-4" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                                <p class="text-gray-500 text-sm">No conversations yet.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Upgrade Card -->
                <div class="space-y-6 animate-fade-in-up stagger-5">
                    <div
                        class="glass-card rounded-2xl p-8 relative overflow-hidden group hover:shadow-[0_0_40px_rgba(0,212,255,0.3)] transition-all duration-300">
                        <!-- Gradient Overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-br from-[#00D4FF]/10 to-purple-500/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>

                        <div class="relative z-10">
                            <div class="flex items-center gap-3 mb-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-gradient-to-br from-[#00D4FF] to-blue-500 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold">Upgrade to Pro</h3>
                            </div>
                            <p class="text-sm text-gray-400 mb-6 leading-relaxed">Unlock higher rate limits, priority
                                support, and exclusive features.</p>
                            <a href="{{ route('pricing') }}"
                                class="inline-block py-3 px-8 rounded-xl font-bold text-black bg-gradient-to-r from-[#00D4FF] to-blue-500 hover:shadow-[0_0_30px_rgba(0,212,255,0.4)] transition-all duration-300 transform hover:scale-105 active:scale-95 text-sm uppercase tracking-wide">
                                View Plans
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom Delete Confirmation Modal -->
    <div id="deleteModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm flex items-center justify-center z-50 hidden">
        <div
            class="glass-card rounded-2xl p-8 max-w-md mx-4 animate-fade-in-up shadow-[0_0_60px_rgba(0,0,0,0.5)] border border-white/10">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-12 h-12 rounded-xl bg-red-500/20 flex items-center justify-center">
                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white">Delete All Conversations</h3>
            </div>
            <p class="text-gray-400 mb-8 leading-relaxed">Are you sure you want to delete all conversations? This action
                cannot be undone.</p>
            <div class="flex justify-end gap-3">
                <button onclick="hideDeleteConfirm()"
                    class="px-6 py-3 text-gray-400 hover:text-white transition-colors rounded-xl hover:bg-white/5 font-medium">
                    Cancel
                </button>
                <form id="deleteForm" action="{{ route('conversations.destroyAll') }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-6 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition-all duration-300 font-bold transform hover:scale-105 active:scale-95">
                        Delete All
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showDeleteConfirm() {
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function hideDeleteConfirm() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('deleteModal').addEventListener('click', function (e) {
            if (e.target === this) {
                hideDeleteConfirm();
            }
        });
    </script>

    <script>
        // Listen for credit updates from chat
        window.addEventListener('credits-updated', (e) => {
            const creditElements = document.querySelectorAll('[x-data*="credits"]');
            creditElements.forEach(element => {
                const alpineData = element.__x || element._x_dataStack?.[0];
                if (alpineData && alpineData.credits !== undefined) {
                    alpineData.credits = Math.max(0, alpineData.credits - e.detail.creditsUsed);
                }
            });
        });

        // Listen for conversation updates
        window.addEventListener('conversation-updated', () => {
            // Refresh dashboard stats without page reload
            fetch('{{ route('dashboard') }}', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.text())
                .then(html => {
                    // Parse the HTML and update stats
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');

                    // Update total queries
                    const totalQueriesElement = doc.querySelector('.text-3xl');
                    if (totalQueriesElement) {
                        const currentTotalQueries = document.querySelector('.text-3xl');
                        if (currentTotalQueries) {
                            currentTotalQueries.textContent = totalQueriesElement.textContent;
                        }
                    }
                })
                .catch(error => console.error('Failed to update dashboard:', error));
        });
    </script>
@endsection