@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0A0A0A] text-white font-['Inter'] relative overflow-hidden">
    <header class="relative z-10 px-6 py-6 max-w-7xl mx-auto flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">CONQ<span class="text-[#00D4FF]">.</span></a>
        <a href="{{ route('pricing') }}" class="text-sm text-gray-400 hover:text-white flex items-center gap-2">← Back to Pricing</a>
    </header>

    <main class="relative z-10 px-6 pt-10 pb-20 max-w-4xl mx-auto">
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight">Upgrade to <span class="text-[#00D4FF]">Pro</span></h1>
            <p class="text-xl text-gray-400 max-w-2xl mx-auto">Get unlimited access to all AI models and priority support.</p>
        </div>

        <div class="bg-[#121212] border border-[#333] rounded-2xl p-8">
            <div class="mb-8">
                <h2 class="text-2xl font-semibold mb-4">Pro Plan Summary</h2>
                <div class="flex items-baseline mb-4">
                    <span class="text-4xl font-bold">$19</span>
                    <span class="text-gray-500 ml-2">/month</span>
                </div>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#00D4FF]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-300">Everything in Starter</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#00D4FF]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-300">Unlimited queries</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#00D4FF]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-300">Access to Reasoning AI & Math AI</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#00D4FF]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-300">Priority response speed</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-[#00D4FF]" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-gray-300">Early access to new features</span>
                    </li>
                </ul>
            </div>

            <form action="{{ route('subscription.process') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <h3 class="text-lg font-semibold mb-4">Payment Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Card Number</label>
                            <input type="text" placeholder="1234 5678 9012 3456" 
                                   class="w-full px-4 py-3 bg-[#1A1A1A] border border-[#333] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-[#00D4FF]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Name on Card</label>
                            <input type="text" placeholder="John Doe" 
                                   class="w-full px-4 py-3 bg-[#1A1A1A] border border-[#333] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-[#00D4FF]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Expiry Date</label>
                            <input type="text" placeholder="MM/YY" 
                                   class="w-full px-4 py-3 bg-[#1A1A1A] border border-[#333] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-[#00D4FF]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">CVV</label>
                            <input type="text" placeholder="123" 
                                   class="w-full px-4 py-3 bg-[#1A1A1A] border border-[#333] rounded-lg text-white placeholder-gray-500 focus:outline-none focus:border-[#00D4FF]">
                        </div>
                    </div>
                </div>

                <div class="border-t border-[#333] pt-6">
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-400">Subtotal</span>
                        <span class="text-xl font-semibold">$19.00</span>
                    </div>
                    <div class="flex justify-between items-center mb-6">
                        <span class="text-gray-400">Total</span>
                        <span class="text-2xl font-bold">$19.00</span>
                    </div>
                </div>

                <button type="submit" class="w-full py-4 rounded-lg font-semibold text-lg bg-[#00D4FF] text-black hover:bg-[#00E5FF] transition-colors">
                    Complete Upgrade - $19/month
                </button>
                
                <p class="text-center text-gray-500 text-sm">
                    You can cancel anytime. No hidden fees.
                </p>
            </form>
        </div>
    </main>
</div>
@endsection
