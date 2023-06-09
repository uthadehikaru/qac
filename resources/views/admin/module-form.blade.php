<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
        {{ __($module?'Edit':'Buat') }} Modul
        - <a href="{{ route('admin.courses.index', [$course->id]) }}" class="pointer text-blue-500">@lang('Course') {{ $course->name }}</a>
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
        @if($module)
        action="{{ route('admin.courses.modules.update', [$module->course_id, $module->id]) }}"
        @else
        action="{{ route('admin.courses.modules.store', [$course->id]) }}"
        @endif
        enctype="multipart/form-data">
        @csrf

        @if($module)
            <input name="_method" type="hidden" value="PUT">
        @endif
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-module_no">
                        No Modul
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-module_no" name="module_no" type="number" placeholder="module module_no" value="{{ old('module_no', $module?$module->module_no:0) }}">
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-name">
                        Name
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-name" name="name" type="text" placeholder="module name" value="{{ old('name', $module?$module->name:'') }}">
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-name">
                        Member Status
                    </label>
                    <div class="relative">
                        <select class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded" 
                        id="grid-member_status" name="member_status">
                        @foreach($memberStatus as $key=>$status)
                        <option value="{{ $key }}" {{ $module && $module->member_status==$key?'selected':'' }}>@lang('batch.status_'.$status)</option>
                        @endforeach
                        </select>
                    </div>
                    <span class="text-sm text-gray-800">status anggota yang berhak mengakses modul</span>
                </div>
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-filename">
                        File
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-filename" name="filename" type="file">
                </div>
                @if($module && $module->file)
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-filename">
                        unduh
                    </label>
                    <a href="{{ $module->file->fileUrl('filename') }}" target="_blank"
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3">
                    {{ $module->file->name }}
                    </a>
                </div>
                @endif
            </div>
        </div>
        </form>
    </x-panel>
</x-app-layout>