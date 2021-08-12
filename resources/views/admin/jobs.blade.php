<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Email Processor') }}
        </h2>
    </x-slot>

    @if(session()->has('message'))
        <x-alert type="success">{{ session('message') }}</x-alert>
    @endif
    @if(session()->has('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
    @endif

    <section class="text-gray-600 body-font bg-white">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap -m-4 text-center">
        <div class="p-4 md:w-1/2 w-full">
            <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-blue-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
            </svg>
            <h2 class="title-font font-medium text-3xl text-gray-900">{{ $jobs }}</h2>
            <p class="leading-relaxed">Sedang dikirim</p>
            </div>
        </div>
        <div class="p-4 md:w-1/2 w-full">
            <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-red-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">            
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h2 class="title-font font-medium text-3xl text-gray-900">{{ $failed_jobs }}</h2>
            <p class="leading-relaxed">Gagal dikirim</p>
            @if($failed_jobs>0)
            <a href="{{ route('admin.jobs.retry') }}" class="pointer text-blue-500 underline">Proses ulang</a>
            @endif
            </div>
        </div>
        </div>
    </div>
    </section>
</x-app-layout>