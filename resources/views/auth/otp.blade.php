<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        @if(session('status'))
            <x-alert type="success" title="Berhasil">{{ session('status') }}</x-alert>
        @endif
        
        @if(session('error'))
            <x-alert type="warning" title="Peringatan">{{ session('error') }}</x-alert>
        @endif

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route($email?'auth.otp':'auth.otp.request') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email/Telp')" />

                <x-input id="email" class="block mt-1 w-full" type="text" name="email_or_phone" :value="old('email_or_phone',$email)" required autofocus />
            </div>

            @if($email)
            <!-- Password -->
            <div class="mt-4">
                <x-label for="password">{{ __('OTP') }}</x-label>

                <x-input id="password" class="block mt-1 w-full"
                                type="number"
                                name="password"
                                required />
            </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="ml-2 underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Kembali ke login') }}
                </a>

                @if($email)
                <x-button class="ml-3">
                    {{ __('Masuk') }}
                </x-button>
                @else
                <x-button class="ml-3">
                    {{ __('Kirim OTP') }}
                </x-button>
                @endif
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
