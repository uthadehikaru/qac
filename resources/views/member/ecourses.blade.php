<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __('My Courses') }}
        </h2>
    </x-slot>

    <x-panel>
        <div class="flex flex-wrap -m-4">
            @foreach ($ecourses as $ecourse)
            <div class="xl:w-1/3 md:w-1/2 p-4">
                <div class="bg-gray-100 p-6 rounded-lg">
                    <img class="h-40 rounded w-full object-cover object-center mb-6" src="{{ $ecourse->imageUrl('thumbnail') }}" alt="content" />
                    <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ $ecourse->title }}</h2>
                    <p class="leading-relaxed text-base mb-4">{{ $ecourse->description }}</p>
                    <a href="{{ route('member.ecourses.show', $ecourse->slug) }}" class="bg-green-500 rounded rounded-full p-2 text-white text-sm">Start Course</a>
                </div>
            </div>
            @endforeach
        </div>
    </x-panel>
    
</x-app-layout>