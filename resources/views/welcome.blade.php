<x-web-layout>
    <!--Hero-->
        <div class="pt-16 pb-8">
            <div class="container-full mx-auto flex flex-wrap flex-col md:flex-row items-center">
                <div class="owl-carousel">
                    @forelse ($banners as $banner)
                    <a href="{{ $banner->url }}" class="w-full text-center"><img src="{{ $banner->imageUrl('image') }}" /></a>
                    @empty
                    <div class="w-full text-center"><img src="{{ asset('images/banner.jpg') }}" /></div>
                    @endforelse
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

        <x-latest-courses :courses="$courses" :waitinglist="$waitinglist" />
        
        <x-latest-event :events="$latest_events" />

        <section id="why" class="bg-white pt-12 py-8 background">
        <div class="container max-w-5xl mx-auto m-8">
            <h1 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
            @lang('Kenapa perlu belajar Bahasa Arab?')
            </h1>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <div class="flex flex-wrap">
                <div class="w-full sm:w-1/3 p-6">
                    <video width="400" height="800" controls controlsList="nodownload">
                        <source src="{{ asset('media/why1.1.mp4') }}?v=20240205" type="video/mp4">
                    </video>
                </div>
                <div class="w-full sm:w-1/3 p-6">
                    <video width="400" height="800" controls controlsList="nodownload">
                        <source src="{{ asset('media/why2.1.mp4') }}?v=20240205" type="video/mp4">
                    </video>
                </div>
                <div class="w-full sm:w-1/3 p-6">
                    <video width="400" height="800" controls controlsList="nodownload">
                        <source src="{{ asset('media/why3.mp4') }}?v=20240205" type="video/mp4">
                    </video>
                </div>
            </div>
        </div>
        </section>

        <section id="about" class="bg-white pt-12 py-8 background">
        <div class="container max-w-5xl mx-auto m-8">
            <h1 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-800">
            @lang('Kenapa belajar Bahasa Arab di QAC?')
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
            <video width="400" height="400" controls controlsList="nodownload">
            <source src="{{ asset('apa itu qac.mp4') }}" type="video/mp4">
            </video>
            </div>
            <div class="w-full sm:w-1/3 p-6">
            <video width="400" height="400" controls controlsList="nodownload">
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

        <section id="testimonial" class="text-gray-600 body-font background">
            <div class="container px-5 py-8 mx-auto">
                <h1 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-900">
                    @lang('Testimoni Alumni')
                </h1>
                <div class="w-full mb-4">
                    <div class="h-1 mx-auto bg-red-800 w-1/6 opacity-25 my-0 py-0 rounded-t"></div>
                </div>
                <div class="flex flex-wrap -m-4">
                    @foreach($testimonials as $testimonial)
                    <div class="lg:w-1/3 lg:mb-0 mb-6 p-4">
                        <div class="h-full text-center">
                        <p class="text-gray-800 text-xl font-bold my-3">{{ $testimonial->batch->full_name }}</p>
                        <p class="leading-relaxed text-gray-600 text-left">
                            {!! nl2br(substr($testimonial->testimonial,0,500)) !!} ...
                        </p>
                        <span class="inline-block h-1 w-10 rounded bg-indigo-500 mt-6 mb-4"></span>
                        <p class="text-gray-600 text-xl">{{ $testimonial->member->full_name }}</p>
                        <h2 class="text-gray-900 font-medium title-font tracking-wider text-sm">{{ $testimonial->member->profesi }}</h2>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="flex flex-wrap px-6 justify-center">
                    <a href="{{ route('testimonials') }}" class="mx-auto lg:mx-0 hover:underline bg-red-800 text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                        Lihat Semua
                    </a>
                </div>
            </div>
        </section>
        <section id="register" class="mx-auto text-center mb-12 background">
        <h1 class="w-full my-2 text-5xl font-bold leading-tight text-center text-gray-900">
            @lang('Bergabung Bersama Para Pejuang')
        </h1>
        <div class="w-full mb-4">
            <div class="h-1 mx-auto bg-red-800 w-1/6 opacity-25 my-0 py-0 rounded-t"></div>
        </div>
        <h3 class="my-4 text-3xl leading-tight">
            @lang('Jadilah bagian dari ribuan alumni')
        </h3>
        <a href="#courses" class="mt-2 mx-auto lg:mx-0 hover:underline bg-red-800 text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
            @lang('Daftar')
        </a>
        </section>
        @if($popup_image)
        <!-- begin : modal -->
        <div class="fixed z-10 overflow-y-auto top-20 w-full left-0" id="popup">
            <div class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                    <div class="absolute inset-0 bg-gray-900 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:h-screen">&#8203;</span>
                <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl 
                transform transition-all max-w-4xl sm:my-12 w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="text-black px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <img src="{{ asset('storage/'.$popup_image) }}" class="w-full" />
                        
                        <div class="bg-white px-4 py-3 text-center">
                            <button type="button" id="close-popup" class="py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2" onclick="togglePopup()">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
<x-slot name="styles">
<link rel="stylesheet" href="{{ asset('owlcarousel/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('owlcarousel/assets/owl.theme.default.min.css') }}">
</x-slot>
<x-slot name="scripts">
    <script src="owlcarousel/owl.carousel.min.js"></script>
    <script>
        jQuery(document).ready(function($){
            $(".owl-carousel").owlCarousel({
                items:1,
                loop:true,
                autoplay: true,
                autoplayTimeout:3000,
                animateOut: 'fadeOut',
            });
            
    @if($popup_image)
            $('#close-popup').click(function(){
                $('#popup').addClass('hidden')
            })
    @endif
        });
    </script>
</x-slot>
</x-web-layout>