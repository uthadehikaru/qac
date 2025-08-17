<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __('Setting') }}
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

        <form id="form" method="post" action="{{ route('admin.systems.store') }}"
        enctype="multipart/form-data">
            @csrf

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-about_1">
                            About 1
                        </label>
                        <textarea class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-about_1" name="about_1" >{{ json_encode($about_1) }}</textarea>
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-about_2">
                            About 2
                        </label>
                        <textarea class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-about_2" name="about_2" >{{ json_encode($about_2) }}</textarea>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-whatsapp">
                            Whatsapp Number
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-whatsapp" type="text" name="whatsapp" value="{{ $whatsapp }}" />
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-whatsapp_ecourse">
                            Whatsapp Ecourse
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-whatsapp_ecourse" type="text" name="whatsapp_ecourse" value="{{ $whatsapp_ecourse }}" />
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-ecource_access_month">
                            Ecourse Class Access (month)
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-ecource_access_month" type="text" name="ecource_access_month" value="{{ $ecource_access_month }}" />
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-popup_image">
                            Popup Image
                            @if($popup_image)
                            <a href="{{ asset('storage/'.$popup_image) }}" target="_blank" class="text-blue-500 underline">image popup</a>
                            @endif
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-popup_image" type="file" name="popup_image" accept="image" />
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-popup_active">
                            Popup Active
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                            id="grid-popup_active" name="popup_active" >
                            <option value="1" {{ $popup_active?'selected':'' }}>Yes</option>
                            <option value="0" {{ !$popup_active?'selected':'' }}>No</option>
                        </select>
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-waitinglist">
                            Open Waiting List
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-waitinglist" name="waitinglist" >
                        <option value="1" {{ $waitinglist?'selected':'' }}>Yes</option>
                        <option value="0" {{ !$waitinglist?'selected':'' }}>No</option>
                    </select>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-qac-1-lite-1a">
                            Course QAC 1.0 Lite 1A
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-qac-1-lite-1a" name="qac_1_lite_1a" >
                            <option value="" {{ $qac_1_lite_1a?'selected':'' }}>Select Course</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $qac_1_lite_1a == $course->id?'selected':'' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-waitinglist">
                            Course QAC 1.0 Lite 1B
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-qac-1-lite-1b" name="qac_1_lite_1b" >
                            <option value="" {{ $qac_1_lite_1b?'selected':'' }}>Select Course</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $qac_1_lite_1b == $course->id?'selected':'' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-qac-1">
                            Course QAC 1.0
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-qac-1" name="qac_1" >
                            <option value="" {{ $qac_1?'selected':'' }}>Select Course</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $qac_1 == $course->id?'selected':'' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-qac-2">
                            Course QAC 2.0
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-qac-2" name="qac_2" >
                            <option value="" {{ $qac_2?'selected':'' }}>Select Course</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $qac_2 == $course->id?'selected':'' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-qac-3">
                            Course QAC 3.0
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-qac-3" name="qac_3" >
                            <option value="" {{ $qac_3?'selected':'' }}>Select Course</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ $qac_3 == $course->id?'selected':'' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-inactive_days">
                            Inactive Days
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-inactive_days" type="number" name="inactive_days" value="{{ $inactive_days }}" />
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-faq">
                            FAQ Content (Markdown Editor)
                        </label>
                        <textarea class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-faq" name="faq" rows="20" placeholder="Enter FAQ content in markdown format...">{{ $faq }}</textarea>
                        <p class="text-sm text-gray-600 mt-2">
                            <strong>Markdown Editor Features:</strong><br>
                            • Toolbar with formatting buttons<br>
                            • Live preview toggle<br>
                            • Auto-save functionality<br>
                            • Keyboard shortcuts (Ctrl+B for bold, Ctrl+I for italic, etc.)
                        </p>
                    </div>
                </div>
            </div>
        </form>
        
        <h1 class="font-bold text-xl mb-2">Video {{ $why1->value }}</h1>
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-1/2">
                <form action="{{ route('upload.media', ['system',$why1->id, 'videos']) }}"
                class="dropzone"
                id="why1-files"></form>
            </div>
            <div class="w-full md:w-1/2">
                
            <ul class="ml-8 list-decimal">
                @foreach ($why1->getMedia('videos') as $media)
                    <li>
                        <div class="flex gap-2">
                        <a href="{{ $media->getFullUrl() }}" class="text-blue-500">{{ $media->file_name }}</a>
                        <form action="{{ route('admin.media.destroy', $media->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="submit" class="text-red-500">delete</button>
                        </form>
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>

        <h1 class="font-bold text-xl my-2">Video {{ $why2->value }}</h1>
        <div class="flex flex-col md:flex-row">
            <div class="w-full md:w-1/2">
                <form action="{{ route('upload.media', ['system',$why2->id, 'videos']) }}"
                class="dropzone"
                id="why1-files"></form>
            </div>
            <div class="w-full md:w-1/2">
                
            <ul class="ml-8 list-decimal">
                @foreach ($why2->getMedia('videos') as $media)
                    <li>
                        <div class="flex gap-2">
                        <a href="{{ $media->getFullUrl() }}" class="text-blue-500">{{ $media->file_name }}</a>
                        <form action="{{ route('admin.media.destroy', $media->id) }}" method="post">
                            @csrf
                            <input type="hidden" name="_method" value="DELETE" />
                            <button type="submit" class="text-red-500">delete</button>
                        </form>
                        </div>
                    </li>
                @endforeach
                </ul>
            </div>
        </div>
    </x-panel>
    <x-slot name="styles">        
        <link href="{{ asset('fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('dropzone-5.9.3/dropzone.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://unpkg.com/easymde/dist/easymde.min.css">
    </x-slot>
    <x-slot name="scripts">        
        <script src="{{ asset('fileuploads/js/fileupload.js') }}"></script>
        <script src="{{ asset('dropzone-5.9.3/dropzone.min.js') }}"></script>
        <script src="https://unpkg.com/easymde/dist/easymde.min.js"></script>
        <script>
            // Initialize EasyMDE markdown editor
            document.addEventListener('DOMContentLoaded', function() {
                const easyMDE = new EasyMDE({
                    element: document.getElementById('grid-faq'),
                    spellChecker: false,
                    autosave: {
                        enabled: true,
                        uniqueId: 'faq-content',
                        delay: 1000,
                    },
                    toolbar: [
                        'bold', 'italic', 'heading', '|',
                        'quote', 'unordered-list', 'ordered-list', '|',
                        'link', 'image', '|',
                        'preview', 'side-by-side', 'fullscreen', '|',
                        'guide'
                    ],
                    placeholder: 'Enter FAQ content in markdown format...',
                    status: ['lines', 'words', 'cursor'],
                    minHeight: '400px',
                    maxHeight: '600px',
                    renderingConfig: {
                        singleLineBreaks: false,
                        codeSyntaxHighlighting: true,
                    }
                });

                // Sync with form submission
                document.getElementById('form').addEventListener('submit', function() {
                    document.getElementById('grid-faq').value = easyMDE.value();
                });
            });
        </script>
    </x-slot>
</x-app-layout>