<x-web-layout>
    <section class="mt-20 bg-white text-gray-600 body-font overflow-hidden">
    <div class="container px-5 py-24 mx-auto">
        <div class="-my-8 divide-y-2 divide-gray-100">
            @foreach($latestEvents as $event)
            <div class="py-8 flex flex-wrap md:flex-nowrap">
                <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                <span class="font-semibold title-font text-gray-700">EVENT</span>
                <span class="mt-1 text-gray-500 text-sm">{{ $event->event_at->format('d M Y H:i') }}</span>
                </div>
                <div class="md:flex-grow">
                <h2 class="text-2xl font-medium text-gray-900 title-font mb-2">{{ $event->title }}</h2>
                <a href="{{ route('event.detail', $event->slug) }}" class="text-indigo-500 inline-flex items-center mt-4">Selengkapnya
                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M5 12h14"></path>
                    <path d="M12 5l7 7-7 7"></path>
                    </svg>
                </a>
                </div>
            </div>
            @endforeach
        </div>
        {{ $latestEvents->links() }}
    </div>
    </section>
</x-web-layout>