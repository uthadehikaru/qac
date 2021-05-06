<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __($system?'Edit':'New') }} {{ __('System') }}
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

        <form id="form" method="post" action="{{ route('admin.systems.'.($system?'update':'store'), ($system?$system->id:null)) }}"
        enctype="multipart/form-data">
        @csrf

        @if($system)
            <input name="_method" type="hidden" value="PUT">
        @endif
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-key">
                        @lang('Key')
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-key" name="key" type="text" placeholder="system date" value="{{ old('key', $system?$system->key:'') }}">
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-is_array">
                        @lang('JSON')
                    </label>
                    <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-is_array" name="is_array">
                        <option value="0" {{ $system && !$system->is_array?'selected':'' }}>Tidak</option>
                        <option value="1" {{ $system && $system->is_array?'selected':'' }}>Ya</option>
                    </select>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-value">
                        @lang('Value')
                    </label>
                    <textarea rows="10" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" 
                    id="grid-value" name="value" placeholder="system value">{{ old('value', $system?$value:'') }}</textarea>
                </div>
            </div>
        </div>
        </form>
    </x-panel>
</x-app-layout>