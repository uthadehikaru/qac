<section id="events" class="bg-white text-gray-600 body-font pt-12 background">
    <div class="container px-5 py-2 mx-auto">
        <div class="text-center mb-20">
            <h1 class="text-md md:text-xl font-bold text-center title-font text-gray-900 mb-4">
            Event QAC
            </h1>
            <div class="w-full mb-4">
            <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <p class="text-md md:text-xl leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto">
            Kegiatan atau program yang terbuka untuk UMUM
            </p>
        </div>
        <div class="flex flex-wrap -m-4">
            @foreach($events as $event)
            <div class="p-8 w-1/2">
                <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                <a href="{{ route('event.detail', $event->slug) }}" class=""><img class="w-full object-cover object-center" src="{{ $event->imageUrl('thumbnail') }}" alt="{{ $event->title }}"></a>
                    <div class="p-6">
                        <h1 class="title-font text-lg font-medium text-gray-900 mb-3">{{ $event->title }}</h1>
                        <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">
                            {{ $event->event_at->format('d M Y H:i') }}
                            | {{ $event->course?'Khusus Alumni '.$event->course->name:'Umum' }}
                        </h2>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="flex flex-wrap px-6 justify-center">
            <a href="{{ route('event.list') }}" class="mx-auto lg:mx-0 hover:underline bg-red-800 text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                Lihat Semua
            </a>
        </div>
    </div>
</section>