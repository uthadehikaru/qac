<x-member-layout>
    
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form id="profile" method="post" action="{{ route('member.profile.update') }}">
        @csrf
        <div class="px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-full_name">
                        Nama Lengkap
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4"
                    id="grid-full_name" name="full_name" type="text" placeholder="Your Full Name" value="{{ Auth::user()->member->full_name }}" required>
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-name">
                        Nama Panggilan
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-name" name="name" type="text" placeholder="Your name" value="{{ Auth::user()->name }}" required>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-email">
                        Email
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-darker rounded py-3 px-4 mb-3" 
                    id="grid-email" name="email" type="email" placeholder="Your Email" value="{{ Auth::user()->email }}" disabled>
                    <p class="text-red text-xs italic">@lang('Email tidak dapat diubah')</p>
                </div>
                <div class="md:w-1/3 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-phone">
                        Whatsapp
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4"
                    id="grid-phone" name="phone" type="number" placeholder="Your Phone" value="{{ Auth::user()->member->phone }}" required>
                </div>
                <div class="md:w-1/3 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-gender">
                        Jenis Kelamin
                    </label>
                    <div class="relative">
                        <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" 
                        id="grid-gender" name="gender" required>
                        <option value="pria" {{ Auth::user()->member->gender=='pria'?'selected':'' }}>Pria</option>
                        <option value="wanita" {{ Auth::user()->member->gender=='wanita'?'selected':'' }}>Wanita</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-profesi">
                        Profesi
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-profesi" name="profesi" type="text" placeholder="Your profesi" value="{{ Auth::user()->member->profesi }}" required>
                </div>
                <div class="md:w-1/3 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-pendidikan">
                        Pendidikan
                    </label>
                    <div class="relative">
                        <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" 
                        id="grid-pendidikan" name="pendidikan" required>
                        @foreach($educations as $education)
                        <option value="{{ $education }}" {{ Auth::user()->member->pendidikan==$education?'selected':'' }}>{{ $education }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="md:w-1/3 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-address">
                        Domisili
                    </label>
                    <textarea class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" 
                    id="grid-address" name="address" placeholder="your address">{{ Auth::user()->member->address }}</textarea>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <x-qac-button href="{{ route('member.password') }}">
                        Ubah Password
                    </x-qac-button>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3">
                    <div class="relative">
                        <label class="inline-flex items-center">
                            <input type="checkbox" class="form-checkbox h-5 w-5 text-gray-600" name="is_notify" value="1" {{ Auth::user()->is_notify ? 'checked' : '' }}>
                            <span class="ml-2 text-gray-700">Saya bersedia menerima notifikasi Email dari QAC</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-[#7b0c00] text-white font-bold py-2 px-4 rounded-full">
                    Simpan
                </button>
            </div>
        </div>
        </form>
    
<x-slot name="scripts">
    <script type="text/javascript">
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
    </script>
</x-slot>
</x-member-layout>