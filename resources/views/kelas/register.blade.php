<x-web-layout>
    <x-auth-card>
        <x-slot name="logo">
            @if($lite)
            <h1 class="text-2xl font-bold text-center mt-24 md:mt-48">Pendaftaran QAC 1.0 Lite</h1>
            @else
            <h1 class="text-2xl font-bold text-center mt-24 md:mt-48">Pendaftaran {{ $batch ? '' : 'Waiting List'}} <br> {{ $course->name }}</h1>
            @endif
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

                <form method="POST" action="{{ route('kelas.register', ['course_id' => $course->id]) }}">
                    @csrf
                    @if($batch)
                    <input type="hidden" name="batch_id" value="{{ $batch->id }}" />
                    @endif
                    @if($course)
                    <input type="hidden" name="course_id" value="{{ $course->id }}" />
                    @endif
                    <input type="hidden" name="lite" value="{{ $lite }}" />

                    @if(!$is_registered)
                    <!-- Full Name -->
                    <div class="mt-4">
                        <x-label for="full_name" :value="__('Full Name')" />

                        <x-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name', $member->full_name)" required />
                    </div>

                    <p class="text-red-500">*pastikan nama lengkap sesuai kartu identitas. akan digunakan untuk pembuatan e-sertifikat</p>

                    <!-- Phone -->
                    <div class="mt-4">
                        <x-label for="phone" :value="__('Nomor WhatsApp')" />

                        <x-input id="phone" class="block mt-1 w-full" placeholder="masukkan dengan format 6281234567890" type="text" name="phone" :value="old('phone', $member->phone)" required />
                    </div>

                    <p class="text-red-500">*pastikan nomor whatsapp aktif, untuk diinfokan terkait kelas</p>
                    
                    <!-- Job -->
                    <div class="mt-4">
                        <x-label for="job" :value="__('Job')" />

                        <x-input id="job" class="block mt-1 w-full" type="text" name="job" :value="old('job', $member->profesi)" />
                    </div>
                    
                    <!-- Education -->
                    <div class="mt-4">
                        <x-label for="education" :value="__('Education')" />

                        <select id="education" class="block mt-1 w-full p-2 rounded-md shadow-sm border-2 border-gray-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="education">
                            <option value="">Pilih Pendidikan Terakhir</option>
                            <option value="SD" {{ old('education', $member->pendidikan) == 'SD' ? 'selected' : '' }}>SD</option>
                            <option value="SMP" {{ old('education', $member->pendidikan) == 'SMP' ? 'selected' : '' }}>SMP</option>
                            <option value="SMA" {{ old('education', $member->pendidikan) == 'SMA' ? 'selected' : '' }}>SMA/SMK</option>
                            <option value="D3" {{ old('education', $member->pendidikan) == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ old('education', $member->pendidikan) == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ old('education', $member->pendidikan) == 'S2' ? 'selected' : '' }}>S2</option>
                            <option value="S3" {{ old('education', $member->pendidikan) == 'S3' ? 'selected' : '' }}>S3</option>
                        </select>
                    </div>
                    
                    <!-- Province -->
                    <div class="mt-4">
                        <x-label for="province_id" :value="__('Province')" />

                        <select id="province_id" class="block mt-1 w-full p-2 rounded-md shadow-sm border-2 border-gray-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="province">
                            <option value="">Pilih Provinsi</option>
                            @foreach($provinces as $province)
                            <option value="{{ $province->id }}" {{ old('province', $member_province) == $province->id ? 'selected' : '' }}>{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Regency -->
                    <div class="mt-4">
                        <x-label for="regency_id" :value="__('Regency')" />

                        <select id="regency_id" class="block mt-1 w-full p-2 rounded-md shadow-sm border-2 border-gray-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="regency">
                            <option value="">Pilih Kota</option>
                            @foreach($regencies as $regency)
                            <option value="{{ $regency->id }}" {{ old('regency', $member_regency) == $regency->id ? 'selected' : '' }}>{{ $regency->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <p class="text-red-500">*pilih provinsi dan kota di Indonesia sesuai asal domisili namun
                    jika anda berada diluar negeri, silakan cheklist box dibawah ini</p>
                    
                    <div class="md:flex md:items-left my-6">
                        <label class="md:w-full block text-gray-500 font-bold">
                        <input class="mr-2 leading-tight" type="checkbox" name="is_overseas" value="1" {{ old('is_overseas', $member->is_overseas) == 1 ? 'checked' : '' }}>
                        <span class="text-sm">
                            Saat ini berada di luar negeri
                        </span>
                        </label>
                    </div>
                    <p class="text-sm text-gray-500">** pilih provinsi dan kota di indonesia sesuai asal domisili jika anda berada diluar negeri</p>
                    @else
                    <input type="hidden" name="full_name" value="{{ $member->full_name }}" />
                    <input type="hidden" name="phone" value="{{ $member->phone }}" />
                    <input type="hidden" name="job" value="{{ $member->profesi }}" />
                    <input type="hidden" name="education" value="{{ $member->pendidikan }}" />
                    <input type="hidden" name="regency" value="{{ $member_regency }}" />
                    <input type="hidden" name="province" value="{{ $member_province }}" />
                    <input type="hidden" name="is_overseas" value="{{ $member->is_overseas }}" />
                    @endif

                    @if($lite)
                    <!-- Pilihan Kelas -->
                    <div class="mt-4">
                        <x-label class="text-xl font-bold" :value="__('Pilihan Kelas')" />

                        <div class="mt-6">
                            <label class="block text-gray-500 font-bold">
                                <input type="radio" name="package" value="1a" class="mr-2 leading-tight" required>
                                <span class="text-sm">
                                    QAC 1a (Rp 300.000,-)
                                </span>
                            </label>
                        </div>

                        @if($is_registered)
                        <div class="mt-4">
                            <label class="block text-gray-500 font-bold">
                                <input type="radio" name="package" value="1b" class="mr-2 leading-tight" required>
                                <span class="text-sm">
                                    QAC 1b (Rp 300.000,-)
                                </span>
                            </label>
                        </div>
                        @endif

                        <div class="mt-4">
                            <label class="block text-gray-500 font-bold">
                                <input type="radio" name="package" value="bundling" class="mr-2 leading-tight" required>
                                <span class="text-sm">
                                    Bundling QAC 1a dan QAC 1b (Rp 550.000,-)
                                </span>
                            </label>
                        </div>
                    </div>
                    @endif
                    <div class="mt-4 text-blue-500">
                        <x-label class="text-center text-xl py-2" for="password_confirmation" :value="__('Syarat dan Ketentuan')" />
                        <p class="text-sm py-2">Saya dengan senang hati akan melakukan hal berikut: *</p>
                        @if($batch)
                        <p class="text-sm">1. Saya berperan aktif mengikuti rangkaian kursus dengan bahagia, ceria dan tetap positif</p>
                        <p class="text-sm">2. Akan bersungguh-sungguh mengikuti kursus ini</p>
                        <p class="text-sm">3. Akan menjalin kerjasama baik antar peserta dan penyelenggara</p>
                        <p class="text-sm">4. Komitmen waktu 60 menit pada setiap sesi yang telah ditentukan (Konsekuensi terlambat/tidak hadir online, tidak ada pengulangan)</p>
                        <p class="text-sm">5. Bila berhalangan darurat, silahkan menginformasikan 1 hari sebelumnya</p>
                        <p class="text-sm">6. Bersabar menunggu respon dari penyelenggara</p>
                        <P class="font-bold">Perhatian! Pendaftaran ini hanya untuk 1 orang, anda tidak diperbolehkan untuk membagikan materi dalam bentuk apapun kepada orang lain. *</p>
                        @elseif($course)
                        <p class="text-sm">1. Saya berperan aktif mengikuti rangkaian kursus dengan bahagia, ceria dan tetap positif</p>
                        <p class="text-sm">2. Akan bersungguh-sungguh mengikuti kursus ini</p>
                        <p class="text-sm">3. Akan menjalin kerjasama baik antar peserta dan penyelenggara</p>
                        @endif
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
                        <x-button id="register-btn" class="ml-4" type="submit">
                            {{ __('Register') }}
                        </x-button>
                    </div>
                </form>
    </x-auth-card>

    <x-slot name="scripts">
        <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
        <script type="text/javascript">

            // Disable register button on form submission
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.querySelector('form[method="POST"]');
                const registerBtn = document.getElementById('register-btn');
                
                if (form && registerBtn) {
                    form.addEventListener('submit', function(e) {
                        // Prevent double submission
                        if (registerBtn.disabled) {
                            e.preventDefault();
                            return false;
                        }
                        
                        // Disable button and show loading state
                        registerBtn.disabled = true;
                        registerBtn.textContent = '{{ __("Registering...") }}';
                        registerBtn.classList.add('opacity-50', 'cursor-not-allowed');
                        
                        // Also disable all form inputs to prevent changes during submission
                        const formInputs = form.querySelectorAll('input, select, textarea');
                        formInputs.forEach(input => {
                            input.disabled = true;
                        });
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

</x-web-layout>