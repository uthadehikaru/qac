<section id="events" class="bg-white text-gray-600 body-font pt-12">
    <div class="container px-5 py-2 mx-auto">
        <div class="text-center mb-20">
            <h1 class="sm:text-3xl text-2xl font-medium text-center title-font text-gray-900 mb-4">
            Event Alumni
            </h1>
            <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto">
            ikuti kegiatan khusus para alumni QAC
            </p>
        </div>
        <div class="flex flex-wrap -m-4">
            @foreach($events as $event)
            <div class="p-8 md:w-1/3">
                <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                <a href="{{ route('event.detail', $event->slug) }}" class=""><img class="w-full object-cover object-center" src="{{ $event->imageUrl('thumbnail') }}" alt="{{ $event->title }}"></a>
                    <div class="p-6">
                        <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">
                            {{ $event->event_at->format('d M Y H:i') }}
                            | {{ $event->course?'Khusus Alumni '.$event->course->name:'Umum' }}
                        </h2>
                        <h1 class="title-font text-lg font-medium text-gray-900 mb-3">{{ $event->title }}</h1>
                        <div class="flex items-center flex-wrap ">
                            <a href="{{ route('event.detail', $event->slug) }}" class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">Selengkapnya
                                <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M5 12h14"></path>
                                <path d="M12 5l7 7-7 7"></path>
                                </svg>
                            </a>
                            <span class="text-gray-400 mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm py-1">
                                <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                                </svg>{{ $event->views }}
                            </span>
                        </div>
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