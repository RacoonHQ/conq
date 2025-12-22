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

            <h3 class="text-2xl font-bold text-white mb-2">Guest Limit Reached</h3>
            <p class="text-[#A0A0A0] mb-8 text-sm leading-relaxed max-w-xs">
                You've reached the free usage limit for guests. Sign up to continue chatting and save your history.
            </p>

            <div class="grid grid-cols-1 w-full gap-3">
                <a href="{{ route('register') }}" class="w-full py-3 rounded-xl font-semibold text-black flex items-center justify-center gap-2 hover:scale-[1.02] transition-transform bg-[#00D4FF]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    Create Free Account
                </a>
                <a href="{{ route('login') }}" class="w-full py-3 rounded-xl font-semibold text-white bg-[#252525] border border-[#333] hover:bg-[#333] flex items-center justify-center gap-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    Sign In
                </a>
            </div>
            
            <p class="mt-6 text-xs text-[#555]">
                No credit card required for standard accounts.
            </p>
        </div>
    </div>
</div>