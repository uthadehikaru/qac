<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __($ecourse?'Edit':'New') }} {{ __('Online Course') }}
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

        <form id="form" method="post" action="{{ route('admin.ecourses.'.($ecourse?'update':'store'), ($ecourse?$ecourse->id:null)) }}"
        enctype="multipart/form-data">
            @csrf

            @if($ecourse)
                <input name="_method" type="hidden" value="PUT">
            @endif
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-title">
                            @lang('Title')
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-title" name="title" type="text" placeholder="ecourse title" value="{{ old('title', $ecourse?$ecourse->title:'') }}">
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-slug">
                            @lang('Slug')
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-slug" name="slug" type="text" placeholder="ecourse slug" value="{{ old('slug', $ecourse?$ecourse->slug:'') }}" readonly>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">
                    <div class="w-full px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-description">
                            @lang('Description')
                        </label>
                        <textarea class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-description" name="description" type="text" placeholder="ecourse description">{{ old('description', $ecourse?$ecourse->description:'') }}</textarea>
                    </div>
                </div>
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-thumbnail">
                            @lang('Thumbnail') (1024 x 683 px)
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-thumbnail" name="thumbnail" type="file" value="{{ old('thumbnail', $ecourse?$ecourse->thumbnail:'') }}">
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-thumbnail">
                            Kelas
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-course_id" name="course_id">
                            <option value="">Umum</option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}" {{ $ecourse && $ecourse->course_id==$course->id?'selected':'' }}>{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-is_only_active_batch">
                            Type
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-is_only_active_batch" name="is_only_active_batch">
                            <option value="0" @selected($ecourse && !$ecourse->is_only_active_batch)>Langganan</option>
                            <option value="1" @selected($ecourse && $ecourse->is_only_active_batch)>Kelas Aktif</option>
                        </select>
                    </div>
                    <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-is_only_active_batch">
                            Category
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-category_id" name="category_id">
                            <option value="">-- pilih kategori --</option>
                            @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $ecourse && $ecourse->category_id==$category->id?'selected':'' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </x-panel>
</x-app-layout>