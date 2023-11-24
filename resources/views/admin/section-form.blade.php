<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('admin.ecourses.index') }}" class="font-semibold text-xl text-blue-500 leading-tight inline">
            Online Courses
        </a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            - {{ __($section?'Edit':'New') }} {{ __('Section') }}
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

        <form id="form" method="post" 
        @if($section)
        action="{{ route('admin.sections.update', $section->id) }}"
        @else
        action="{{ route('admin.sections.store') }}"
        @endif
        enctype="multipart/form-data">
            @csrf

            @if($section)
                <input name="_method" type="hidden" value="PUT">
            @endif
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-name">
                            @lang('Name')
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-name" name="name" type="text" placeholder="section name" value="{{ old('name', $section?$section->name:'') }}">
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-order_no">
                            @lang('Order No')
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-order_no" name="order_no" type="number" placeholder="section order_no" value="{{ old('order_no', $section?$section->order_no:'0') }}">
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-thumbnail">
                            @lang('Thumbnail') (1024 x 683 px)
                        </label>
                        <input class="dropify appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        type="file" name="thumbnail"
                        data-allowed-file-extensions="jpg png jpeg"
                        data-allowed-formats="landscape"
                        data-max-file-size="2M"
                        data-default-file="{{ $section? $section->imageUrl('thumbnail'): '' }}" />
                    </div>
                </div>
            </div>
        </form>
    </x-panel>
    <x-slot name="styles">        
        <link href="{{ asset('fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    </x-slot>
    <x-slot name="scripts">        
        <script src="{{ asset('fileuploads/js/fileupload.js') }}"></script>
        <script>
            $('.dropify').dropify({
                messages: {
                    'default': 'drop file or click here',
                    'replace': 'drop file or click to replace',
                    'remove': 'Remove',
                    'error': 'Ooops, something wrong appended.'
                },
                error: {
                    'fileSize': 'The file size is too big (2M max).'
                }
            });
        </script>
    </x-slot>
</x-app-layout>