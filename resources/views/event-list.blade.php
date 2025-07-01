<x-web-layout>
    <x-slot name="title"> - Event QAC</x-slot>
    <section class="mt-20 text-gray-600 body-font overflow-hidden">
        <div class="relative py-4">
            <div class="overflow-hidden mx-8 border border-yellow-500 py-1 px-2 rounded-full">
                <div class="flex justify-between lg:justify-center filter-carousel transition-transform duration-300 ease-in-out text-black">
                    @foreach($eventCategories as $category)
                    <a href="{{ route('event.list', ['category' => $category->slug]) }}" class="px-4 py-2 {{ $category->id == $selectedEventCategory->id ? 'bg-yellow-500 hover:text-white' : 'hover:bg-yellow-500 hover:text-white' }} rounded-full flex items-center whitespace-nowrap mr-2 text-xs">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex flex-wrap mx-2">
            @forelse($latest_events as $event)
            <div class="w-full md:w-1/3 p-4">
                <a href="{{ route('event.detail', $event->slug) }}" class="ecourse" title="{{ $event->title }}">
                    <div class="rounded-lg">
                        <img class="rounded-lg border border-gray-200 w-full object-cover object-center mb-6" src="{{ $event->imageUrl('thumbnail') }}" alt="{{ $event->title }}">
                        <h2 class="text-xs text-gray-900 font-medium title-font mb-2">{{ $event->title }}</h2>
                        <p class="text-xs text-gray-500">{{ $event->lessons_count }} Videos, {{ $event->ebooks_count }} E-Books</p>
                    </div>
                </a>
            </div>
            @empty
            <div class="w-full text-center p-4 h-64 flex items-center justify-center">
                <p class="text-black font-bold text-xs md:text-base">Segera Hadir Event-Event Baru, Insyaa Allah</p>
            </div>
            @endforelse
        </div>
    </section>
    <div class="fixed bottom-4 right-4 text-sm flex gap-2 items-center bg-white">
        <p>Jika mengalami kendala, silakan hubungi whatsapp kami.</p>
        <a href="https://wa.me/6281234567890" class="bg-green-400 px-4 py-2 rounded-full text-black text-sm">Whatsapp</a>
    </div>
</x-web-layout>