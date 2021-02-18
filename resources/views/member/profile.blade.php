<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __('Profile') }}
        </h2>
        <x-link-button  href="javascript:void(0)" onclick="document.getElementById('profile').submit();" id="save" class="float-right">Simpan</x-button>
    </x-slot>

    <x-panel>
    
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form id="profile" method="post" action="{{ route('member.profile.update') }}">
        @csrf
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-name">
                        Name
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-name" name="name" type="text" placeholder="Your name" value="{{ Auth::user()->name }}">
                </div>
                <div class="md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-phone">
                        Phone
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4"
                    id="grid-phone" name="phone" type="text" placeholder="Your Phone" value="{{ Auth::user()->member->phone }}">
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-email">
                        Email
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-darker rounded py-3 px-4 mb-3" 
                    id="grid-email" name="email" type="email" placeholder="Your Email" value="{{ Auth::user()->email }}" disabled>
                    <p class="text-red text-xs italic">@lang('Email tidak dapat diubah')</p>
                </div>
                <div class="md:w-1/2 px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-gender">
                        Gender
                    </label>
                    <div class="relative">
                        <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" 
                        id="grid-gender" name="gender">
                        <option value="pria" {{ Auth::user()->member->gender=='pria'?'selected':'' }}>Pria</option>
                        <option value="wanita" {{ Auth::user()->member->gender=='wanita'?'selected':'' }}>Wanita</option>
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
                    id="grid-address" name="address" placeholder="your address">{{ Auth::user()->member->address }}</textarea>
                    <p class="text-red text-xs italic">@lang('Digunakan untuk pengiriman')</p>
                </div>
            </div>
        </div>
        </form>
    </x-panel>
</x-app-layout>