<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __($quiz?'Edit':'New') }} {{ __('Quiz') }}
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

        <form id="form" method="post" action="{{ route('admin.quiz.'.($quiz?'update':'store'), ($quiz?$quiz->id:null)) }}"
        enctype="multipart/form-data">
        @csrf

        @if($quiz)
            <input name="_method" type="hidden" value="PUT">
        @endif
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-start_date">
                        @lang('Start Date')
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-start_date" name="start_date" type="date" placeholder="start date" value="{{ old('start_date', $quiz?$quiz->start_date->format('Y-m-d'):'') }}">
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-end_date">
                        @lang('End Date')
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-end_date" name="end_date" type="date" placeholder="end date" value="{{ old('end_date', $quiz?$quiz->end_date->format('Y-m-d'):'') }}">
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-is_public">
                        @lang('Quiz Course')
                    </label>
                    <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-course_id" name="course_id">
                        <option value="" {{ $quiz && $quiz->is_public?'selected':'' }}>Umum</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ $quiz && $quiz->course_id==$course->id?'selected':'' }}>{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-duration">
                        @lang('Duration (Minute)')
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-duration" name="duration" type="number" placeholder="quiz duration" value="{{ old('duration', $quiz?$quiz->duration:'') }}">
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-name">
                        @lang('Name')
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-name" name="name" type="text" placeholder="quiz name" value="{{ old('name', $quiz?$quiz->name:'') }}">
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-description">
                        @lang('Description')
                    </label>
                    <textarea rows="10" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" 
                    id="grid-description" name="description" placeholder="quiz description">{{ old('description', $quiz?$quiz->description:'') }}</textarea>
                </div>
            </div>
        </div>
        </form>
    </x-panel>
</x-app-layout>