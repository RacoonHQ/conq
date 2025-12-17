@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#121212] text-[#E0E0E0] font-['Inter']">
    <header class="fixed top-0 left-0 right-0 z-50 bg-[#121212]/90 backdrop-blur-md border-b border-[#333]">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">CONQ<span class="text-[#00D4FF]">.</span></a>
            <span class="px-2 py-0.5 rounded bg-[#222] text-xs text-gray-400 border border-[#333]">Docs</span>
        </div>
    </header>

    <div class="max-w-7xl mx-auto px-6 pt-24 pb-20 flex">
        <aside class="w-64 fixed hidden md:block">
            <div class="space-y-4">
                <a href="#intro" class="block text-[#00D4FF]">Introduction</a>
                <a href="#auth" class="block text-gray-500 hover:text-gray-300">Authentication</a>
            </div>
        </aside>
        <main class="md:ml-64 flex-1">
            <section id="intro" class="mb-20">
                <h1 class="text-4xl font-bold mb-6 text-white">Introduction</h1>
                <p class="text-lg text-gray-400">Welcome to the CONQ platform documentation.</p>
            </section>
        </main>
    </div>
</div>
@endsection