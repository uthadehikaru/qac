<x-web-layout>
<div class="mt-12 py-12 text-gray-900">
    <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-4xl text-center w-full">
                @lang('Pendaftaran')
                @if($batch)
                    {{ $batch->full_name }}
                @else
                    {{ 'Waiting List '.$course->name }}
                @endif
                </h2>

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
                    <!-- Full Name -->
                    <div>
                        <x-label for="full_name" :value="__('Full Name')" />

                        <x-input id="full_name" class="block mt-1 w-full" type="text" name="full_name" :value="old('full_name')" required />
                        <p class="text-sm text-gray-500">* pastikan nama lengkap sesuai kartu identitas. akan digunakan untuk pembuatan e-sertifikat</p>
                    </div>

                    <!-- Short Name -->
                    <div class="mt-4">
                        <x-label for="name" :value="__('Short Name')" />

                        <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required />
                    </div>


                    <!-- Phone -->
                    <div class="mt-4">
                        <x-label for="phone" :value="__('Nomor Whatsapp')" />

                        <x-input id="phone" class="block mt-1 w-full" type="number" name="phone" placeholder="Masukkan nomor telp dengan kode negara tanpa tanda +. con. 6281212341234" :value="old('phone')" required />
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

                    @if($batch || $course)
                    <div class="md:flex md:items-left my-6">
                        <label class="md:w-full block text-gray-500 font-bold">
                        <input class="mr-2 leading-tight" type="checkbox" name="is_overseas" value="1">
                        <span class="text-sm">
                            Saat ini berada di luar negeri
                        </span>
                        </label>
                    </div>

                    <!-- Address -->
                    <div class="mt-4">
                        <x-label for="address" :value="__('Address')" />

                        <textarea id="address" class="block mt-1 w-full" type="text" name="address" required>{{ old('address') }}</textarea>
                        <p class="text-sm text-gray-500">** gunakan alamat domisili di indonesia jika anda berada diluar negeri</p>
                    </div>

                    <div class="mt-4">
                        <x-label for="province_id" :value="__('Provinsi')" />

                        <select id="province_id" class="block mt-1 w-full" name="province_id" required>
                            <option value="">-- pilih provinsi --</option>
                            @foreach($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-label for="regency_id" id="regency_label" :value="__('Kota')" />

                        <select id="regency_id" class="block mt-1 w-full" name="regency_id" required>
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-label for="district_id" id="district_label" :value="__('Kecamatan')" />

                        <select id="district_id" class="block mt-1 w-full" name="district_id" required>
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-label for="village_id" id="village_label" :value="__('Kelurahan')" />

                        <select id="village_id" class="block mt-1 w-full" name="village_id" required>
                        </select>
                    </div>
                    <div class="mt-4">
                        <x-label for="zipcode" :value="__('Kode Pos')" />

                        <x-input id="zipcode" class="block mt-1 w-full" type="text" name="zipcode" :value="old('zipcode')" />
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
                        <x-button class="ml-4">
                            {{ __('Register') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<x-slot name="scripts">
    <script type="text/javascript">
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
        if($('#regency_id').length){
            $('#regency_id').on('change', function() {
                $("#district_label").addClass('animate-bounce');
                $("#district_id").empty();
                $("#village_id").empty();
                var regency_id = $(this).val();
                $.ajax({
                    type:"POST",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    url:"{{ url('api/districts') }}/"+regency_id,
                    success: function(data) {
                        $("#district_id").html($("<option></option>").val(0).html('-- pilih kecamatan --'));
                        $.each(data, function (key, row)
                        {
                            $("#district_id").append($("<option></option>").val(row.id).html(row.name));
                        });
                        $("#district_label").removeClass('animate-bounce');
                    },
                    error: function(data) {
                        $("#district_label").removeClass('animate-bounce');
                    }
                });
            });
        }
        if($('#district_id').length){
            $('#district_id').on('change', function() {
                $("#village_label").addClass('animate-bounce');
                $("#village_id").empty();
                var district_id = $(this).val();
                $.ajax({
                    type:"POST",
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    url:"{{ url('api/villages') }}/"+district_id,
                    success: function(data) {
                        $("#village_id").html($("<option></option>").val(0).html('-- pilih kelurahan --'));
                        $.each(data, function (key, row)
                        {
                            $("#village_id").append($("<option></option>").val(row.id).html(row.name));
                        });
                        $("#village_label").removeClass('animate-bounce');
                    },
                    error: function(data) {
                        $("#village_label").removeClass('animate-bounce');
                    }
                });
            });
        } 
    </script>
</x-slot>
</x-web-layout>
