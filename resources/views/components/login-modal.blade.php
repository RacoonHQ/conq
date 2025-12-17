<div x-show="showLoginModal" 
     x-cloak 
     class="fixed inset-0 z-[100] flex items-center justify-center p-4">
    
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black/70 backdrop-blur-sm" 
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="showLoginModal = false"></div>
    
    <!-- Modal Content -->
    <div class="relative w-full max-w-md bg-[#1A1A1A] border border-[#333] rounded-2xl shadow-2xl p-6"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 scale-95">
        
        <button @click="showLoginModal = false" class="absolute top-4 right-4 text-gray-500 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>

        <div class="flex flex-col items-center text-center">
            <div class="w-16 h-16 rounded-full bg-[#151515] border border-[#333] flex items-center justify-center mb-6">
                <svg class="w-8 h-8 text-[#00D4FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>

            <h3 class="text-2xl font-bold text-white mb-2">Login Required</h3>
            <p class="text-[#A0A0A0] mb-8 text-sm leading-relaxed max-w-xs">
                You need to sign in to access advanced features, save your history, and upload files.
            </p>

            <div class="grid grid-cols-1 w-full gap-3">
                <a href="{{ route('register') }}" class="w-full py-3 rounded-xl font-semibold text-black flex items-center justify-center gap-2 hover:scale-[1.02] transition-transform bg-[#00D4FF]">
                    Create Free Account
                </a>
                <a href="{{ route('login') }}" class="w-full py-3 rounded-xl font-semibold text-white bg-[#252525] border border-[#333] hover:bg-[#333] flex items-center justify-center gap-2 transition-colors">
                    Sign In
                </a>
            </div>
            
            <p class="mt-6 text-xs text-[#555]">
                No credit card required for standard accounts.
            </p>
        </div>
    </div>
</div>