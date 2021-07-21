<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __($event?'Edit':'New') }} {{ __('Event') }}
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

        <form id="form" method="post" action="{{ route('admin.events.'.($event?'update':'store'), ($event?$event->id:null)) }}"
        enctype="multipart/form-data">
        @csrf

        @if($event)
            <input name="_method" type="hidden" value="PUT">
        @endif
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-event_at">
                        @lang('Event Date')
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-event_at" name="event_at" type="datetime-local" placeholder="event date" value="{{ old('event_at', $event?$event->event_at->format('Y-m-d\TH:i'):'') }}">
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-is_public">
                        @lang('Event Course')
                    </label>
                    <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-course_id" name="course_id">
                        <option value="" {{ $event && $event->is_public?'selected':'' }}>Umum</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ $event && $event->course_id==$course->id?'selected':'' }}>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-title">
                        @lang('Title')
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-title" name="title" type="text" placeholder="event title" value="{{ old('title', $event?$event->title:'') }}">
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-content">
                        @lang('Content')
                    </label>
                    <textarea rows="10" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" 
                    id="grid-content" name="content" placeholder="event content">{{ old('content', $event?$event->content:'') }}</textarea>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-thumbnail">
                        @lang('Thumbnail')
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-thumbnail" name="thumbnail" type="file" placeholder="event thumbnail" value="{{ old('thumbnail', $event?$event->thumbnail:'') }}">
                </div>
            </div>
        </div>
        </form>
    </x-panel>
</x-app-layout>