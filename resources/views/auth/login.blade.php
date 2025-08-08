<x-guest-layout>
    <x-slot name="title">
        - Masuk
    </x-slot>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        @if(session('error'))
        <x-alert type="warning" title="Perhatian">{{ session('error') }}</x-alert>
        @endif

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div>
                <x-label for="email" :value="__('Email/Telp')" />

                <x-input id="email" class="block mt-1 w-full" type="text" name="email_or_phone" :value="old('email_or_phone')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <div class="relative">
                    <x-input id="password" class="block mt-1 w-full pr-10"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                    <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password')">
                        <svg id="password-eye" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        <svg id="password-eye-slash" class="h-5 w-5 text-gray-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="ml-2 underline text-sm text-blue-500" href="{{ route('auth.otp') }}">
                    {{ __('Gunakan OTP') }}
                </a>
                @if (Route::has('password.request'))
                    <a class="ml-2 underline text-sm text-blue-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-3 bg-[#7b0c00] text-white">
                    {{ __('Login') }}
                </x-button>
            </div>
            <div class="flex flex-col items-center justify-center mt-4">
                <p class="text-sm text-gray-600">Belum punya akun? Daftar disini:</p>
                <a class="px-4 py-2 border border-[#7b0c00] text-[#7b0c00] font-bold rounded-md mt-2 text-xs" href="{{ route('register', ['register_only' => true]) }}">
                    {{ __('Daftar') }}
                </a>
            </div>
        </form>
    </x-auth-card>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
    // Password visibility toggle function
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const eyeIcon = document.getElementById(fieldId + '-eye');
        const eyeSlashIcon = document.getElementById(fieldId + '-eye-slash');
        
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeSlashIcon.classList.remove('hidden');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('hidden');
            eyeSlashIcon.classList.add('hidden');
        }
    }
    </script>
</x-guest-layout>
