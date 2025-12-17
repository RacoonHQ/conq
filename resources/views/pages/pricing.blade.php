@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0A0A0A] text-white font-['Inter'] relative overflow-hidden">
    <header class="relative z-10 px-6 py-6 max-w-7xl mx-auto flex items-center justify-between">
        <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">CONQ<span class="text-[#00D4FF]">.</span></a>
        <a href="{{ route('home') }}" class="text-sm text-gray-400 hover:text-white flex items-center gap-2">Back</a>
    </header>

    <main class="relative z-10 px-6 pt-10 pb-20 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold mb-6 tracking-tight">Simple pricing, <span class="text-[#00D4FF]">powerful</span> results</h2>
        </div>
        <!-- Simplified Plans -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-[#121212] border border-[#333] rounded-2xl p-8">
                <h3 class="text-xl font-semibold mb-2">Starter</h3>
                <span class="text-4xl font-bold">Free</span>
                <p class="text-gray-400 text-sm mt-4">Perfect for exploring.</p>
                <button class="w-full py-3 rounded-lg font-semibold text-sm bg-[#222] text-white mt-8">Get Started</button>
            </div>
            <div class="bg-[#151515] border border-[#00D4FF] rounded-2xl p-8 transform md:-translate-y-4">
                <div class="text-[#00D4FF] text-xs font-bold mb-2">MOST POPULAR</div>
                <h3 class="text-xl font-semibold mb-2">Pro</h3>
                <span class="text-4xl font-bold">$19</span><span class="text-gray-500">/mo</span>
                <p class="text-gray-400 text-sm mt-4">For professionals.</p>
                <button class="w-full py-3 rounded-lg font-semibold text-sm bg-[#00D4FF] text-black mt-8">Upgrade</button>
            </div>
             <div class="bg-[#121212] border border-[#333] rounded-2xl p-8">
                <h3 class="text-xl font-semibold mb-2">Enterprise</h3>
                <span class="text-4xl font-bold">Custom</span>
                <p class="text-gray-400 text-sm mt-4">For teams.</p>
                <button class="w-full py-3 rounded-lg font-semibold text-sm bg-[#222] text-white mt-8">Contact Sales</button>
            </div>
        </div>
    </main>
</div>
@endsection