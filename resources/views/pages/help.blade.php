@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#0A0A0A] text-white font-['Inter']">
    <header class="border-b border-[#222] bg-[#121212]">
        <div class="max-w-4xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">CONQ<span class="text-[#00D4FF]">.</span></a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-6 py-12">
        <h2 class="text-3xl font-bold mb-8">Help Center</h2>
        <div class="space-y-4">
            <div class="border border-[#333] rounded-xl bg-[#121212] p-5">
                <h4 class="font-semibold text-gray-200 mb-2">How do I switch agents?</h4>
                <p class="text-sm text-gray-400">Use the dropdown menu in the chat input area.</p>
            </div>
            <div class="border border-[#333] rounded-xl bg-[#121212] p-5">
                <h4 class="font-semibold text-gray-200 mb-2">Is my data private?</h4>
                <p class="text-sm text-gray-400">Yes, conversations are stored securely.</p>
            </div>
        </div>
    </main>
</div>
@endsection