<x-web-layout>

    <x-panel class="mt-20">
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ $ecourse->level ? route('ecourses.index') : route('event.list') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        {{ $ecourse->level ? 'Program Alumni' : 'Event QAC' }}
                    </a>
                </li>
                <li class="inline-flex items-center">
                    <a href="{{ $ecourse->level ? route('ecourses.index', ['category' => $ecourse->category->slug]) : route('event.list', ['category' => $ecourse->category->slug]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        {{ $ecourse->category->name }}
                    </a>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $ecourse->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="flex flex-col md:flex-row gap-8">
            <div class="w-full md:w-2/3">
                <img alt="{{ $ecourse->title }}" class="w-full h-full object-contain md:object-cover object-center rounded" src="{{ $ecourse->imageUrl('thumbnail') }}" />
                <p>{{ $ecourse->description }}</p>
            </div>
            <div class="w-full md:w-1/3 mt-8 md:mt-0 flex flex-col gap-y-2">
                @forelse ($videos as $video)
                    <x-lesson-card :video="$video" :ecourse="$ecourse" :completed="$completed"
                    :current="$video" />
                @empty
                    <p>Belum ada video</p>
                @endforelse
            </div>
        </div>
</x-panel>
</x-web-layout>