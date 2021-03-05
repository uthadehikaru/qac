<x-web-layout>
<div class="mt-12 py-12 text-gray-900">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-4xl text-center w-full">@lang('Pendaftaran') {{ $batch->full_name }}</h2>

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('register', ['batch_id'=>request('batch_id')]) }}">
                    @csrf

                    <!-- Full Name -->
                    <div>
                        <x-label for="full_name" :value="__('Full Name')" />

                        <x-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required autofocus />
                    </div>

                    <!-- Short Name -->
                    <div class="mt-4">
                        <x-label for="name" :value="__('Short Name')" />

                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                    </div>


                    <!-- Phone -->
                    <div class="mt-4">
                        <x-label for="phone" :value="__('Phone')" />

                        <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" :value="old('phone')" required />
                    </div>

                    <!-- Gender -->
                    <div class="mt-4">
                        <x-label for="gender" :value="__('Gender')" />

                        <select id="gender" class="block mt-1 w-full" name="gender" required>
                            <option value="pria">Pria</option>
                            <option value="wanita">Wanita</option>
                        </select>
                    </div>

                    <!-- Address -->
                    <div class="mt-4">
                        <x-label for="address" :value="__('Address')" />

                        <x-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required />
                    </div>

                    <!-- City -->
                    <div class="mt-4">
                        <x-label for="city" :value="__('City')" />

                        <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required />
                    </div>

                    <!-- Instagram -->
                    <div class="mt-4">
                        <x-label for="instagram" :value="__('Instagram')" />

                        <x-input id="instagram" class="block mt-1 w-full" type="text" name="instagram" :value="old('instagram')" />
                    </div>

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-label for="email" :value="__('Email')" />

                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        <p class="text-sm text-gray-500">* digunakan untuk login</p>
                    </div>

                    @if(is_array($sessions))
                    <!-- Session -->
                    <div class="mt-4">
                        <x-label for="session" :value="__('Sesi')" />

                        <select id="session" class="block mt-1 w-full" name="session" required>
                            @foreach($sessions as $session)
                            <option value="{{ $session }}">{{ $session }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Password')" />

                        <x-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Register') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</x-web-layout>
