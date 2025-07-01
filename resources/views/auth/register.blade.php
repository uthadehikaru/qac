<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        @if(session('error'))
        <x-alert type="warning">{{ session('error') }}</x-alert>
        @endif

                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                @if($batch)
                <p class="py-4">{!! nl2br($batch->course->description) !!}</p>
                <p class="py-4">{!! nl2br($batch->description) !!}</p>
                <p class="py-4">Waktu kursus : {{ $batch->duration }}</p>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    @if($batch)
                    <input type="hidden" name="batch_id" value="{{ $batch->id }}" />
                    @endif
                    @if($course)
                    <input type="hidden" name="course_id" value="{{ $course->id }}" />
                    @endif

                    <!-- Email Address -->
                    <div class="mt-4">
                        <x-label for="email" :value="__('Email')" />

                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                    </div>

                    <!-- Full Name -->
                    <div class="mt-4">
                        <x-label for="full_name" :value="__('Full Name')" />

                        <x-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-label for="password" :value="__('Password')" />

                        <div class="relative">
                            <x-input id="password" class="block mt-1 w-full pr-10"
                                            type="password"
                                            name="password"
                                            required autocomplete="new-password" />
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

                    <!-- Confirm Password -->
                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />

                        <div class="relative">
                            <x-input id="password_confirmation" class="block mt-1 w-full pr-10"
                                            type="password"
                                            name="password_confirmation" required />
                            <button type="button" class="absolute inset-y-0 right-0 pr-3 flex items-center" onclick="togglePassword('password_confirmation')">
                                <svg id="password_confirmation-eye" class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <svg id="password_confirmation-eye-slash" class="h-5 w-5 text-gray-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    @if($batch || $course)
                        <div class="md:flex md:items-left my-6">
                            <label class="md:w-full block text-gray-500 font-bold">
                            <input class="mr-2 leading-tight" type="checkbox" name="is_overseas" value="1">
                            <span class="text-sm">
                                Saat ini berada di luar negeri
                            </span>
                            </label>
                        </div>
                        <p class="text-sm text-gray-500">** pilih provinsi dan kota di indonesia sesuai asal domisili jika anda berada diluar negeri</p>


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
                    @endif

                    @if($batch || $course)
                    <div class="mt-4">
                        <x-label for="password_confirmation" :value="__('Syarat dan Ketentuan')" />
                        <p class="text-sm text-gray-700">Saya dengan senang hati akan melakukan hal berikut: *</p>
                        @if($batch)
                        <p class="text-sm text-gray-700">1. Saya berperan aktif mengikuti rangkaian kursus dengan bahagia, ceria dan tetap positif</p>
                        <p class="text-sm text-gray-700">2. Akan bersungguh-sungguh mengikuti kursus ini</p>
                        <p class="text-sm text-gray-700">3. Akan menjalin kerjasama baik antar peserta dan penyelenggara</p>
                        <p class="text-sm text-gray-700">4. Komitmen waktu 60 menit pada setiap sesi yang telah ditentukan (Konsekuensi terlambat/tidak hadir online, tidak ada pengulangan)</p>
                        <p class="text-sm text-gray-700">5. Bila berhalangan darurat, silahkan menginformasikan 1 hari sebelumnya</p>
                        <p class="text-sm text-gray-700">6. Bersabar menunggu respon dari penyelenggara</p>
                        <P class="font-bold">Perhatian! Pendaftaran ini hanya untuk 1 orang, anda tidak diperbolehkan untuk membagikan materi dalam bentuk apapun kepada orang lain. *</p>
                        @elseif($course)
                        <p class="text-sm text-gray-700">1. Saya berperan aktif mengikuti rangkaian kursus dengan bahagia, ceria dan tetap positif</p>
                        <p class="text-sm text-gray-700">2. Akan bersungguh-sungguh mengikuti kursus ini</p>
                        <p class="text-sm text-gray-700">3. Akan menjalin kerjasama baik antar peserta dan penyelenggara</p>
                        @endif
                    </div>
                    @endif

                    <div class="md:flex md:items-left my-6">
                        <label class="md:w-full block text-gray-500 font-bold">
                        <input class="mr-2 leading-tight" type="checkbox" name="term_condition" required>
                        <span class="text-sm">
                            dengan mendaftar, saya menyetujui <span class="text-blue-500">syarat dan ketentuan</span> yang berlaku
                        </span>
                        </label>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button id="register-btn" class="ml-4" type="submit">
                            {{ __('Register') }}
                        </x-button>
                    </div>
                </form>
                
                <div class="flex flex-col items-center justify-center mt-4">
                    <p class="text-sm text-gray-600">Sudah punya akun? Login disini:</p>
                    <a class="px-4 py-2 border border-[#7b0c00] text-[#7b0c00] font-bold rounded-md mt-2 text-xs" href="{{ route('login') }}">
                        {{ __('Login') }}
                    </a>
                </div>
    </x-auth-card>

    <x-slot name="scripts">
        <script type="text/javascript">
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

            // Disable register button on form submission
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form[method="POST"]');
                const registerBtn = document.getElementById('register-btn');
                
                if (form && registerBtn) {
                    form.addEventListener('submit', function() {
                        registerBtn.disabled = true;
                        registerBtn.textContent = '{{ __("Registering...") }}';
                        registerBtn.classList.add('opacity-50', 'cursor-not-allowed');
                    });
                }
            });

            if($('#province_id').length){
                $('#province_id').on('change', function() {
                    $("#regency_label").addClass('animate-bounce');
                    $("#regency_id").empty();
                    $("#district_id").empty();
                    $("#village_id").empty();
                    var province_id = $(this).val();
                    $.ajax({
                        type:"POST",
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        url:"{{ url('api/regencies') }}/"+province_id,
                        success: function(data) {
                            $("#regency_id").html($("<option></option>").val(0).html('-- pilih kota --'));
                            $.each(data, function (key, row)
                            {
                                $("#regency_id").append($("<option></option>").val(row.id).html(row.name));
                            });
                            $("#regency_label").removeClass('animate-bounce');
                        },
                        error: function(data) {                
                            $("#regency_label").removeClass('animate-bounce');
                        }
                    });
                });
            }
        </script>
    </x-slot>

</x-guest-layout>