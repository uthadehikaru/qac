<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('admin.ecourses.show', $ecourse->id) }}" class="font-semibold text-xl text-blue-500 leading-tight inline">
            {{ $ecourse->title }}
        </a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            - {{ __($lesson?'Edit':'New') }} {{ __('Lesson') }}
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
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-subject">
                            @lang('Description')
                        </label>
                        <textarea class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-description" name="description" placeholder="lesson description">{{ old('description', $lesson?$lesson->description:'') }}</textarea>
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
                        data-default-file="{{ $lesson? $lesson->imageUrl('thumbnail'): '' }}" />
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-section_id">
                            Order No
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-order_no" name="order_no" type="number" placeholder="lesson order no" value="{{ old('order_no', $lesson?$lesson->order_no:0) }}">
                    </div>
                </div>
            </div>
        </form>
        @if($lesson)
        <h2 class="text-xl mb-4">Video</h2>
        <div class="flex gap-x-2">
            <div class="w-1/3">
            <form action="{{ route('upload.lesson.files', ['videos',$lesson->id]) }}"
                class="dropzone"
                id="my-awesome-dropzone">
            </form>
            </div>
            <div class="w-2/3 ml-4">
                <ul class="list-decimal">
                @foreach ($lesson->getMedia('videos') as $media)
                    <li>
                        <a href="{{ $media->getFullUrl() }}" class="text-blue-500">{{ $media->file_name }}</a>
                        <form action="{{ route('admin.media.destroy', $media->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="submit" class="text-red-500">delete</button>
                        </form>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
        <h2 class="text-xl my-4">Download Files</h2>
        <div class="flex gap-x-2">
            <div class="w-1/3">
            <form action="{{ route('upload.lesson.files', ['downloads',$lesson->id]) }}"
                class="dropzone"
                id="my-awesome-dropzone">
            </form>
            </div>
            <div class="w-2/3 ml-4">
                <ul class="list-decimal">
                @foreach ($lesson->getMedia('downloads') as $media)
                    <li>
                        <a href="{{ $media->getFullUrl() }}" class="text-blue-500">{{ $media->file_name }}</a>
                        <form action="{{ route('admin.media.destroy', $media->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="submit" class="text-red-500">delete</button>
                        </form>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
        @endif
    </x-panel>
    <x-slot name="styles">        
        <link href="{{ asset('fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('dropzone-5.9.3/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
    </x-slot>
    <x-slot name="scripts">        
        <script src="{{ asset('fileuploads/js/fileupload.js') }}"></script>
        <script src="{{ asset('dropzone-5.9.3/dropzone.min.js') }}"></script>
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