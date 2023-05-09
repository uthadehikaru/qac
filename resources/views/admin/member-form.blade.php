<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __($member?'Edit':'New') }} {{ __('Member') }}
        </h2>
        <div class="float-right">
            <x-link-button  href="javascript:void(0)" onclick="document.getElementById('form').submit();" id="save" class=" ml-3">Simpan</x-button>
        </div>
    </x-slot>

    <x-panel>
    
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form id="form" method="post" action="{{ route('admin.members.'.($member?'update':'store'), ($member?$member->id:null)) }}">
        @csrf

        @if($member)
            <input name="_method" type="hidden" value="PUT">
        @endif
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-full_name">
                        Nama Lengkap
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-full_name" name="full_name" type="text" placeholder="member full_name" value="{{ old('full_name', $member?$member->full_name:'') }}">
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-name">
                        Nama Panggilan
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-name" name="name" type="text" placeholder="member name" value="{{ old('name', $member?$member->name:'') }}">
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/3 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-phone">
                        Phone
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4"
                    id="grid-phone" name="phone" type="text" placeholder="member Phone" value="{{ old('phone', $member?$member->phone:'') }}">
                </div>
                <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-email">
                        Email
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-darker rounded py-3 px-4 mb-3" 
                    id="grid-email" name="email" type="email" placeholder="member Email" value="{{ old('email', $member?$member->email:'') }}">
                </div>
                <div class="md:w-1/3 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-gender">
                        Gender
                    </label>
                    <div class="relative">
                        <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" 
                        id="grid-gender" name="gender">
                        <option value="pria" {{ $member && $member->gender=='pria'?'selected':'' }}>Pria</option>
                        <option value="wanita" {{ $member && $member->gender=='wanita'?'selected':'' }}>Wanita</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-address">
                        Address
                    </label>
                    <textarea class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" 
                    id="grid-address" name="address" placeholder="member address">{{ old('address', $member?$member->address:'') }}</textarea>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/4 px-3">
                    <label id="province_label" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="province_id">
                        Provinsi
                    </label>
                    <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" 
                    id="province_id" name="province_id" required>
                        <option value="">-- pilih provinsi --</option>
                        @foreach($provinces as $province)
                        <option value="{{ $province->id }}" {{ $province_id==$province->id?'selected':'' }}>{{ $province->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:w-1/4 px-3">
                    <label id="regency_label" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="regency_id">
                        Kota
                    </label>
                    <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" 
                    id="regency_id" name="regency_id" required>
                        @foreach($regencies as $regency)
                        <option value="{{ $regency->id }}" {{ $regency_id==$regency->id?'selected':'' }}>{{ $regency->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:w-1/4 px-3">
                    <label id="district_label" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="district_id">
                        Kecamatan
                    </label>
                    <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" 
                    id="district_id" name="district_id" required>
                        @foreach($districts as $district)
                        <option value="{{ $district->id }}" {{ $district_id==$district->id?'selected':'' }}>{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:w-1/4 px-3">
                    <label id="village_label" class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="village_id">
                        Kelurahan
                    </label>
                    <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" 
                    id="village_id" name="village_id" required>
                        @foreach($villages as $village)
                        <option value="{{ $village->id }}" {{ $village_id==$village->id?'selected':'' }}>{{ $village->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-zipcode">
                        Kode Pos
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-zipcode" name="zipcode" type="text" placeholder="Your zipcode" value="{{ old('zipcode', $member?$member->zipcode:'') }}">
                </div>
                <div class="md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-instagram">
                        Instagram
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4"
                    id="grid-instagram" name="instagram" type="text" placeholder="Your Instagram" value="{{ old('instagram', $member?$member->instagram:'') }}">
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-profesi">
                        Profesi
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-profesi" name="profesi" type="text" placeholder="Your profesi" value="{{ old('profesi', $member?$member->profesi:'') }}">
                </div>
                <div class="md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-instagram">
                        Pendidikan
                    </label>
                    <div class="relative">
                        <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" 
                        id="grid-pendidikan" name="pendidikan" required>
                        @foreach($educations as $education)
                        <option value="{{ $education }}" {{ $member && $member->pendidikan==$education?'selected':'' }}>{{ $education }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-instagram">
                        Luar Negeri
                    </label>
                    <div class="relative">
                    <div class="relative flex gap-x-3">
                        <div class="flex h-6 items-center">
                        <input id="is_overseas" name="is_overseas" type="checkbox" value="1"
                        {{ $member && $member->is_overseas?'checked':'' }}
                        class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
                        </div>
                        <div class="text-sm leading-6">
                        <label for="comments" class="font-medium text-gray-900">Saat ini berada di luar negeri</label>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </x-panel>
    
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
</x-app-layout>