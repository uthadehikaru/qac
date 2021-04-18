<x-web-layout>
<div class="mt-12 py-12 text-gray-900">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-4xl text-center w-full">@lang('Pendaftaran') {{ $batch->full_name }}</h2>

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <p class="py-4">{!! nl2br($batch->course->description) !!}</p>

                <p class="py-4">{!! nl2br($batch->description) !!}</p>

                <p class="py-4">Waktu kursus : {{ $batch->duration }}</p>

                <form method="POST" action="{{ route('register', ['batch_id'=>request('batch_id')]) }}">
                    @csrf

                    <!-- Full Name -->
                    <div>
                        <x-label for="full_name" :value="__('Full Name')" />

                        <x-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required autofocus />
                        <p class="text-sm text-gray-500">* digunakan untuk pembuatan e-sertifikat</p>
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
                        <p class="text-sm text-gray-500">* pastikan nomor whatsapp aktif</p>
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
                        <p class="text-sm text-gray-500">* digunakan untuk pengiriman modul, mohon menulis alamat lengkap</p>
                    </div>

                    <!-- City -->
                    <div class="mt-4">
                        <x-label for="city" :value="__('Kota')" />

                        <x-input id="city" class="block mt-1 w-full" type="text" name="city" :value="old('city')" required />
                    </div>

                    <div class="mt-4">
                        <x-label for="profesi" :value="__('Profesi')" />

                        <x-input id="profesi" class="block mt-1 w-full" type="text" name="profesi" :value="old('profesi')" />
                    </div>

                    <div class="mt-4">
                        <x-label for="pendidikan" :value="__('Pendidikan')" />

                        <select id="pendidikan" class="block mt-1 w-full" name="pendidikan" required>
                            @foreach($educations as $education)
                            <option value="{{ $education }}">{{ $education }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Instagram -->
                    <div class="mt-4">
                        <x-label for="instagram" :value="__('Instagram')" />

                        <x-input id="instagram" class="block mt-1 w-full" type="text" name="instagram" :value="old('instagram')" />
                    </div>

                    @if(is_array($sessions))
                    <!-- Session -->
                    <div class="mt-4">
                        <x-label for="session" :value="__('Pilihan Waktu Kursus')" />

                        <select id="session" class="block mt-1 w-full" name="session" required>
                            @foreach($sessions as $session)
                            <option value="{{ $session }}">{{ $session }}</option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500">mohon pastikan waktu yang sesuai dengan pilihan anda</p>
                    </div>
                    @endif

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-label for="email" :value="__('Email')" />

                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        <p class="text-sm text-gray-500">digunakan untuk login</p>
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Password')" />

                        <x-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                                        
                        <p class="text-sm text-gray-500">digunakan untuk login</p>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required />
                    </div>

                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="__('Syarat dan Ketentuan')" />

                        <p class="text-sm text-gray-700">Saya dengan senang hati akan melakukan hal berikut: *</p>
                        <p class="text-sm text-gray-700">1. Saya berperan aktif mengikuti rangkaian kursus dengan bahagia, ceria dan tetap positif</p>
                        <p class="text-sm text-gray-700">2. Akan bersungguh-sungguh mengikuti kursus ini</p>
                        <p class="text-sm text-gray-700">3. Akan menjalin kerjasama baik antar peserta dan penyelenggara</p>
                        <p class="text-sm text-gray-700">4. Komitmen waktu 60 menit pada setiap sesi yang telah ditentukan (Konsekuensi terlambat/tidak hadir online, tidak ada pengulangan)</p>
                        <p class="text-sm text-gray-700">5. Bila berhalangan darurat, silahkan menginformasikan 1 hari sebelumnya</p>
                        <p class="text-sm text-gray-700">6. Bersabar menunggu respon dari penyelenggara</p>
                        <P class="font-bold">Perhatian! Pendaftaran ini hanya untuk 1 orang, anda tidak diperbolehkan untuk membagikan materi dalam bentuk apapun kepada orang lain. *</p>
                    </div>

                    <div class="md:flex md:items-left my-6">
                        <label class="md:w-full block text-gray-500 font-bold">
                        <input class="mr-2 leading-tight" type="checkbox" name="term_condition" required>
                        <span class="text-sm">
                            dengan mendaftar, saya menyetujui <span class="text-blue-500">syarat dan ketentuan</span> yang berlaku
                        </span>
                        </label>
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
