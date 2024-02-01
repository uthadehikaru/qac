<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __('My Courses') }}
        </h2>
    </x-slot>

    <x-panel>
        <div class="flex flex-wrap -m-4">
            @foreach ($ecourses as $ecourse)
            <div class="md:w-1/2 p-4">
                <x-ecourse-card :ecourse="$ecourse" />
            </div>
            @endforeach
        </div>
    </x-panel>
    
</x-app-layout>