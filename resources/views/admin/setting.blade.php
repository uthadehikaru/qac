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
    </x-slot>
    <x-slot name="scripts">        
        <script src="{{ asset('fileuploads/js/fileupload.js') }}"></script>
        <script src="{{ asset('dropzone-5.9.3/dropzone.min.js') }}"></script>
    </x-slot>
</x-app-layout>