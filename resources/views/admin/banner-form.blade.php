<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __($banner?'Edit':'New') }} {{ __('Banner') }}
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

        <form id="form" method="post" action="{{ route('admin.banners.'.($banner?'update':'store'), ($banner?$banner->id:null)) }}"
        enctype="multipart/form-data">
        @csrf

        @if($banner)
            <input name="_method" type="hidden" value="PUT">
        @endif
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-url">
                        @lang('Url') (link saat gambar diklik)
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-url" name="url" type="text" placeholder="banner url" value="{{ old('url', $banner?$banner->url:'#') }}">
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-is_active">
                        @lang('Is Active')
                    </label>
                    <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-is_active" name="is_active">
                        <option value="1" {{ $banner && $banner->is_active?'selected':'' }}>Ya</option>
                        <option value="0" {{ $banner && !$banner->is_active?'selected':'' }}>Tidak</option>
                    </select>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-image">
                        @lang('Image') (2560 x 1017 px)
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-image" name="image" type="file" placeholder="banner image" value="{{ old('image', $banner?$banner->image:'') }}">
                    
                </div>
            </div>
        </div>
        </form>
    </x-panel>
</x-app-layout>