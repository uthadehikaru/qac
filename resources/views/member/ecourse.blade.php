<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('member.ecourses.index') }}" class=" text-blue-500 font-semibold text-xl text-gray-800 leading-tight inline">
            My Courses
        </a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            - {{ $ecourse->title }}
        </h2>
    </x-slot>

    <x-panel>
        <div class="container mx-auto">
            <img alt="{{ $ecourse->title }}" class="w-full lg:h-auto h-64 object-contain object-center rounded" src="{{ $ecourse->imageUrl('thumbnail') }}" />
            <div class="w-full flex p-6">
                <div class="lg:w-2/3 flex flex-col gap-y-8 mt-4">
                    <h2 class="font-bold text-2xl">Sections ({{ $sections->count() }})</h2>
                    @foreach ($sections as $section)
                        <div class="w-full flex gap-x-4">
                            <img class="w-1/4" src="{{ $section->imageUrl('thumbnail') }}" alt="{{ $section->name }}" />
                            <a href="{{ route('member.ecourses.lessons', $ecourse->slug) }}" class="font-bold text-xl text-blue-500">{{ $section->name }}</a>
                        </div>
                    @endforeach
                </div>
                <div class="lg:w-1/3 flex flex-col mt-4">
                    <h2 class="font-bold text-lg">{{ $completed->count() }} of {{ $ecourse->lessons->count() }} Lessons Completed</h2>                    
                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700 mt-2">
                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ round(($completed->count()/$ecourse->lessons->count())*100) }}%"></div>
                    </div>
                    <div class="mt-12">
                        <p class="text-lg font-bold">Hubungi Kami</p>
                        <p>untuk bantuan lebih lengkap, silahkan hubungi whatsapp kami</p>
                    </div>

                </div>
            </div>
        </div>
</x-panel>
</x-app-layout>