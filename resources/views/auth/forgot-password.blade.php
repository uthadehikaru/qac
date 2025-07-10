<x-guest-layout>
    <x-slot name="title">
        - Lupa Password
    </x-slot>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Kamu lupa password?, jangan khawatir. Masukkan email kamu yang terdaftar dan kami akan mengirimkan tautan untuk mengatur ulang password anda.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="ml-2 underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Kembali ke login') }}
                </a>
                <x-button class="ml-3">
                    {{ __('Kirim') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
