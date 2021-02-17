<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __($batch?'Edit':'New') }} {{ __('Batch') }}
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

        @if($batch)
        <form id="form" method="post" action="{{ route('admin.courses.batches.update', ['course_id'=>$course_id, 'batch'=>$batch->id]) }}">
        @else
        <form id="form" method="post" action="{{ route('admin.courses.batches.store', $course_id) }}">
        @endif
        @csrf

        @if($batch)
            <input name="_method" type="hidden" value="PUT">
        @endif
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-description">
                        Description
                    </label>
                    <textarea class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" 
                    id="grid-description" name="description" placeholder="batch description">{{ old('description',$batch?$batch->description:'') }}</textarea>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-registration_start_at">
                        Registration Start Date
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-registration_start_at" name="registration_start_at" type="date" placeholder="ex: 2021-12-29" value="{{ old('registration_start_at',$batch && $batch->registration_start_at?$batch->registration_start_at->format('Y-m-d'):'') }}">
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-registration_end_at">
                        Registration End Date
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-registration_end_at" name="registration_end_at" type="date" placeholder="ex: 2021-12-29" value="{{ old('registration_end_at',$batch && $batch->registration_end_at?$batch->registration_end_at->format('Y-m-d'):'') }}">
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-start_at">
                        Start Date
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-start_at" name="start_at" type="date" placeholder="ex: 2021-12-29" value="{{ old('start_at',$batch && $batch->start_at?$batch->start_at->format('Y-m-d'):'') }}">
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-end_at">
                        End Date
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-end_at" name="end_at" type="date" placeholder="ex: 2021-12-29" value="{{ old('end_at',$batch && $batch->end_at?$batch->end_at->format('Y-m-d'):'') }}">
                </div>
            </div>
        </div>
        </form>
    </x-panel>
</x-app-layout>