<x-web-layout>
    <!--Hero-->
    <div class="pt-24">
        <div class="container px-3 mx-auto flex flex-wrap flex-col md:flex-row items-center">
            <!--Left Col-->
            <div class="flex flex-col w-full md:w-2/5 justify-center items-start text-center md:text-left">
            <h1 class="my-4 text-5xl font-bold leading-tight">
                @lang('LET QUR\'AN EMBRACES YOUR HEART')
            </h1>
            <p class="leading-normal text-2xl mb-8">
                @lang('Because Every Muslim has right to learn it and get one step closer')
            </p>
            <a href="#about" class="mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                @lang('Tentang QAC')
            </a>
            </div>
            <!--Right Col-->
            <div class="w-full md:w-3/5 py-6 text-center">
            <img class="w-full md:w-3/5 z-50" src="qac banner.png" />
            </div>
        </div>
        </div>
        <div class="relative -mt-12 lg:-mt-24">
        <svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g transform="translate(-2.000000, 44.000000)" fill="#FFFFFF" fill-rule="nonzero">
                <path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
                <path
                d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
                opacity="0.100000001"
                ></path>
                <path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" id="Path-4" opacity="0.200000003"></path>
            </g>
            <g transform="translate(-4.000000, 76.000000)" fill="#FFFFFF" fill-rule="nonzero">
                <path
                d="M0.457,34.035 C57.086,53.198 98.208,65.809 123.822,71.865 C181.454,85.495 234.295,90.29 272.033,93.459 C311.355,96.759 396.635,95.801 461.025,91.663 C486.76,90.01 518.727,86.372 556.926,80.752 C595.747,74.596 622.372,70.008 636.799,66.991 C663.913,61.324 712.501,49.503 727.605,46.128 C780.47,34.317 818.839,22.532 856.324,15.904 C922.689,4.169 955.676,2.522 1011.185,0.432 C1060.705,1.477 1097.39,3.129 1121.236,5.387 C1161.703,9.219 1208.621,17.821 1235.4,22.304 C1285.855,30.748 1354.351,47.432 1440.886,72.354 L1441.191,104.352 L1.121,104.031 L0.457,34.035 Z"
                ></path>
            </g>
            </g>
        </svg>
        </div>
        <section id="about" class="bg-white border-b pt-12 py-8">
        <div class="container max-w-5xl mx-auto m-8">
            <h1 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
            @lang('Tentang Kami')
            </h1>
            <div class="w-full mb-4">
            <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <div class="flex flex-wrap">
            <div class="w-5/6 sm:w-1/3 p-6">
                <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
                {{ $about_1->title }}
                </h3>
                <p class="text-gray-600 mb-8">
                {{ $about_1->content }}
                </p>
            </div>
            <div class="w-full sm:w-1/3 p-6">
            <video width="400" height="400" controls>
            <source src="{{ asset('apa itu qac.mp4') }}" type="video/mp4">
            </video>
            </div>
            <div class="w-full sm:w-1/3 p-6">
            <video width="400" height="400" controls>
            <source src="{{ asset('apa itu qac2.mp4') }}" type="video/mp4">
            </video>
            </div>
            </div>
            <div class="flex flex-wrap flex-col-reverse sm:flex-row">
            <div class="w-full sm:w-1/2 p-6 mt-6">
                <video width="400" height="400" controls>
                <source src="{{ asset('kelas qac2.mp4') }}" type="video/mp4">
                </video>
            </div>
            <div class="w-full sm:w-1/2 p-6 mt-6">
                <div class="align-middle">
                <h3 class="text-3xl text-gray-800 font-bold leading-none mb-3">
                    {{ $about_2->title }}
                </h3>
                <p class="text-gray-600 mb-8">
                    {{ $about_2->content }}
                </p>
                </div>
            </div>
            </div>
        </div>
        </section>
        <section id="testimonial" class="text-gray-600 body-font">
            <div class="container px-5 py-24 mx-auto">
                <h1 class="w-full my-2 text-5xl font-bold leading-tight text-center text-white">
                    @lang('Testimoni Alumni')
                </h1>
                <div class="flex flex-wrap -m-4">
                    @foreach($testimonials as $testimonial)
                    <div class="lg:w-1/3 lg:mb-0 mb-6 p-4">
                        <div class="h-full text-center">
                        <p class="text-gray-800 text-xl font-bold my-3">{{ $testimonial->batch->full_name }}</p>
                        <p class="leading-relaxed text-white text-left">
                            {!! nl2br(substr($testimonial->testimonial,0,500)) !!} ...
                        </p>
                        <span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-6 mb-4"></span>
                        <p class="text-white text-xl">{{ $testimonial->member->full_name }}</p>
                        <h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">{{ $testimonial->member->profesi }}</h2>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="flex flex-wrap px-6 justify-center">
                    <a href="{{ route('testimonials') }}" class="mx-auto lg:mx-0 hover:underline text-black bg-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                        Lihat Semua
                    </a>
                </div>
            </div>
        </section>
        <section id="courses" class="bg-gray-100 pt-2 py-8">
        <div class="container mx-auto px-2 pt-4 pb-2 text-gray-800">
            <h1 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
            @lang('PILIHAN KELAS')
            </h1>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <div class="flex flex-col sm:flex-row justify-center pt-12 my-12 sm:my-4">
                @foreach($courses as $course)
                    @if($course->id==1)
                    <div class="flex flex-col w-5/6 lg:w-1/3 mx-auto lg:mx-0 rounded-lg bg-white mt-4 sm:-mt-6 shadow-lg z-10">
                    @else
                    <div class="flex flex-col w-5/6 lg:w-1/4 mx-auto lg:mx-0 rounded-none lg:rounded-l-lg bg-white mt-4">
                    @endif
                        <div class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden shadow">
                            <div class="p-8 text-3xl font-bold text-center">
                                {{ $course->name }}
                            </div>
                            <div class="h-1 w-full gradient my-0 py-0 rounded-t"></div>
                            <p class="p-3">{!! nl2br($course->description) !!}</p>
                        </div>
                        <div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow p-6">
                        @forelse($course->batches()->open()->get() as $batch)
                            <div class="w-full pt-6 text-3xl text-gray-600 font-bold text-center">
                                Batch {{ $batch->name }}
                                <p class="text-base">{{ $batch->duration }}</p>
                                
                                @if($batch->file)
                                <a href="{{ $batch->file->fileUrl('filename') }}" 
                                class="pointer text-sm text-blue-500">
                                @lang('Unduh') {{ $batch->file->name }} ({{ $batch->file->type }})
                                </a>
                                @endif
                            </div>
                            <div class="flex flex-col items-center justify-center">
                                @if($course->level==1)
                                <a href="{{ route('register', ['batch_id'=>$batch->id]) }}" 
                                class="hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                                @else
                                <a href="{{ route('member.batch.detail', $batch->id) }}" class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                                @endif
                                @lang('Daftar')
                                </a>
                                <p class="text-sm font-italic text-yellow-600">pendaftaran sampai {{ $batch->registration_end_at->format('d F Y')}}</p>
                            </div>
                        @empty
                            @if($waitinglist)
                            <div class="flex flex-col items-center justify-center">
                                <p class="text-sm font-italic text-yellow-600">Maaf, saat ini tidak ada pendaftaran yang dibuka. silahkan masuk daftar tunggu untuk mengikut kelas selanjutnya.</p>
                                @if($course->level==1)
                                <a href="{{ route('register', ['course_id'=>$course->id]) }}" class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                                @else
                                <a href="{{ route('member.waitinglist', $course->id) }}" class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                                @endif
                                @lang('Waiting List') {{ $course->name }}
                                </a>
                            </div>
                            @else
                            <div class="flex flex-col items-center justify-center">
                                <p class="text-sm font-italic text-yellow-600">Maaf, saat ini tidak ada pendaftaran yang dibuka. silahkan menunggu informasi untuk mengikut kelas selanjutnya.</p>
                            </div>
                            @endif
                        @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        </section>
        <x-faq />
        <section id="events" class="bg-white text-gray-600 body-font">
            <div class="container px-5 py-2 mx-auto">
                <div class="text-center mb-20">
                    <h1 class="sm:text-3xl text-2xl font-medium text-center title-font text-gray-900 mb-4">
                    Event Terbaru
                    </h1>
                    <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto">
                    ikuti kegiatan khusus para anggota QAC
                    </p>
                </div>
                <div class="flex flex-wrap -m-4">
                    @foreach($latest_events as $event)
                    <div class="p-4 md:w-1/3">
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
                    <a href="{{ route('event.list') }}" class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                        Lihat Semua
                    </a>
                </div>
            </div>
        </section>
        <!-- Change the colour #f8fafc to match the previous section colour -->
        <svg class="wave-top" viewBox="0 0 1439 147" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g transform="translate(-1.000000, -14.000000)" fill-rule="nonzero">
            <g class="wave" fill="#f8fafc">
                <path
                d="M1440,84 C1383.555,64.3 1342.555,51.3 1317,45 C1259.5,30.824 1206.707,25.526 1169,22 C1129.711,18.326 1044.426,18.475 980,22 C954.25,23.409 922.25,26.742 884,32 C845.122,37.787 818.455,42.121 804,45 C776.833,50.41 728.136,61.77 713,65 C660.023,76.309 621.544,87.729 584,94 C517.525,105.104 484.525,106.438 429,108 C379.49,106.484 342.823,104.484 319,102 C278.571,97.783 231.737,88.736 205,84 C154.629,75.076 86.296,57.743 0,32 L0,0 L1440,0 L1440,84 Z"
                ></path>
            </g>
            <g transform="translate(1.000000, 15.000000)" fill="#FFFFFF">
                <g transform="translate(719.500000, 68.500000) rotate(-180.000000) translate(-719.500000, -68.500000) ">
                <path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
                <path
                    d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
                    opacity="0.100000001"
                ></path>
                <path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" opacity="0.200000003"></path>
                </g>
            </g>
            </g>
        </g>
        </svg>
        <section id="register" class="container mx-auto text-center pt-12 pt-12 py-6 mb-12">
        <h1 class="w-full my-2 text-5xl font-bold leading-tight text-center text-white">
            @lang('Bergabung Bersama Para Pejuang')
        </h1>
        <div class="w-full mb-4">
            <div class="h-1 mx-auto bg-white w-1/6 opacity-25 my-0 py-0 rounded-t"></div>
        </div>
        <h3 class="my-4 text-3xl leading-tight">
            @lang('Jadilah bagian dari ratusan alumni')
        </h3>
        <a href="#courses" class="mt-2 mx-auto lg:mx-0 hover:underline bg-white text-gray-800 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
            @lang('Daftar')
        </a>
        </section>
</x-web-layout>