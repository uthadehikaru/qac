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
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-name">
                        Name
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-name" name="name" type="text" placeholder="member name" value="{{ old('name', $member?$member->name:'') }}">
                </div>
                <div class="md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-phone">
                        Phone
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4"
                    id="grid-phone" name="phone" type="text" placeholder="member Phone" value="{{ old('phone', $member?$member->phone:'') }}">
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-email">
                        Email
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-darker rounded py-3 px-4 mb-3" 
                    id="grid-email" name="email" type="email" placeholder="member Email" value="{{ old('email', $member?$member->email:'') }}">
                </div>
                <div class="md:w-1/2 px-3">
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
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-city">
                        City
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-city" name="city" type="text" placeholder="Your city" value="{{ old('city', $member?$member->city:'') }}">
                </div>
                <div class="md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-instagram">
                        Instagram
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4"
                    id="grid-instagram" name="instagram" type="text" placeholder="Your Instagram" value="{{ old('instagram', $member?$member->instagram:'') }}">
                </div>
            </div>
        </div>
        </form>
    </x-panel>
</x-app-layout>