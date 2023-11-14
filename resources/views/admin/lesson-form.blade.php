<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __($lesson?'Edit':'New') }} {{ __('Lesson') }}
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
        @if($lesson)
        action="{{ route('admin.ecourses.lessons.update', [$ecourse->id, $lesson->id]) }}"
        @else
        action="{{ route('admin.ecourses.lessons.store', $ecourse->id) }}"
        @endif
        enctype="multipart/form-data">
            @csrf

            @if($lesson)
                <input name="_method" type="hidden" value="PUT">
            @endif
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-subject">
                            @lang('Subject')
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-subject" name="subject" type="text" placeholder="lesson subject" value="{{ old('subject', $lesson?$lesson->subject:'') }}">
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-section_id">
                            Section
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-section_id" name="section_id">
                            <option value="">-- Pilih Section --</option>
                            @foreach($sections as $section)
                            <option value="{{ $section->id }}" {{ $lesson && $lesson->section_id==$section->id?'selected':'' }}>{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-thumbnail">
                            @lang('Thumbnail')
                        </label>
                        <input class="dropify appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        type="file" name="thumbnail"
                        data-allowed-file-extensions="jpg png jpeg"
                        data-allowed-formats="landscape"
                        data-max-file-size="2M"
                        data-default-file="{{ $lesson? $lesson->imageUrl('thumbnail'): '' }}" />
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-thumbnail">
                            @lang('Video/Pdf')
                        </label>
                        <input class="dropify appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        type="file" name="filename"
                        data-allowed-file-extensions="mp4 pdf"
                        data-allowed-formats="landscape"
                        data-max-file-size="128M"
                        data-default-file="{{ $lesson && $lesson->file ? $lesson->file->fileUrl('filename'): '' }}" />
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-thumbnail">
                            @lang('Files')
                        </label>
                        <input class="dropify appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        type="file" name="files"
                        data-allowed-file-extensions="jpg png jpeg"
                        data-max-file-size="2M"
                        multiple />
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