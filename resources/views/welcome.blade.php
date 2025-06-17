<x-web-layout>
    <!--Hero-->
        <div class="pt-16 pb-8">
            <div class="container-full mx-auto flex flex-wrap flex-col md:flex-row items-center relative">
                <button class="owl-nav-custom owl-prev absolute left-8 top-1/2 transform -translate-y-1/2 z-10 bg-white bg-opacity-70 rounded-full p-2 shadow hover:bg-red-800 hover:text-white transition" aria-label="Previous"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="#490d0d"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></button>
                <div class="owl-carousel px-24 py-12">
                    @forelse ($banners as $banner)
                    <a href="{{ $banner->url }}" class="w-full text-center"><img src="{{ $banner->imageUrl('image') }}" /></a>
                    @empty
                    <div class="w-full text-center"><img src="{{ asset('images/banner.jpg') }}" /></div>
                    @endforelse
                </div>
                <button class="owl-nav-custom owl-next absolute right-8 top-1/2 transform -translate-y-1/2 z-10 bg-white bg-opacity-70 rounded-full p-2 shadow hover:bg-red-800 hover:text-white transition" aria-label="Next"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="#490d0d"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></button>
            </div>
        </div>

        <section id="why" class="bg-white pt-12 py-8">
        <div class="container max-w-5xl mx-auto m-8">
            <h1 class="w-full my-2 text-xl font-bold leading-tight text-center text-gray-800">
            {{ $why1->value }}
            </h1>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
            </div>
            <div class="flex flex-wrap justify-center">
                <video width="400" height="800" class="border border-gray-300 border-8 rounded-lg" controls controlsList="nodownload">
                    <source src="{{ asset('apa itu qac.mp4') }}" type="video/mp4">
                </video>
            </div>
        </div>
        </section>

        <div class="grid grid-cols-2 gap-4">
            <section id="introduction" class="bg-white pt-12 py-8">
            <div class="container max-w-5xl mx-auto m-8">
                <h1 class="w-full my-2 text-md md:text-xl font-bold leading-tight text-center text-gray-800">
                Yuk, kenali QAC!
                </h1>
                <div class="w-full mb-4">
                    <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
                </div>
                <div class="flex flex-wrap justify-center">
                    <img src="{{ asset('images/introduction.jpeg') }}" />
                </div>
            </div>
            </section>
            <section id="howto" class="bg-white pt-12 py-8">
            <div class="container max-w-5xl mx-auto m-8">
                <h1 class="w-full my-2 text-md md:text-xl font-bold leading-tight text-center text-gray-800">
                Bagaimana metode belajarnya?
                </h1>
                <div class="w-full mb-4">
                    <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
                </div>
                <div class="flex flex-wrap justify-center">
                    <img src="{{ asset('images/howto.jpeg') }}" />
                </div>
            </div>
            </section>
        </div>

        <x-latest-courses :courses="$courses" :waitinglist="$waitinglist" />

        <x-latest-ecourses :ecourses="$ecourses" />

        <x-latest-event :events="$latest_events" />

        <section id="testimonial" class="text-gray-600 body-font ">
            <div class="container px-5 py-8 mx-auto">
                <h1 class="w-full my-2 text-xl font-bold leading-tight text-center text-gray-900">
                    @lang('Apa Kata Alumni QAC?')
                </h1>
                <div class="w-full mb-4">
                    <div class="h-1 mx-auto gradient w-64 my-0 py-0 rounded-t"></div>
                </div>
                <div class="owl-carousel px-24 py-12">
                    @foreach($testimonials as $testimonial)
                    <div class="w-full lg:mb-0 mb-6 p-4 bg-[#fff9e4] rounded-lg">
                        <div class="h-full text-center">
                        <p class="text-gray-800 text-xl font-bold my-3">{{ $testimonial->batch->full_name }}</p>
                        <p class="leading-relaxed text-gray-600 text-left">
                            {!! nl2br(substr($testimonial->testimonial,0,500)) !!} ...
                        </p>
                        <span class="inline-block h-1 w-24 rounded gradient mt-6 mb-4"></span>
                        <p class="text-gray-800 text-xl font-bold">{{ $testimonial->member->full_name }}</p>
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
        <section id="register" class="mx-auto text-center mt-12 mb-12">
        <h1 class="w-full my-2 text-xl font-bold leading-tight text-center text-gray-900">
            @lang('Bergabung Bersama Para Pejuang')
        </h1>
        <div class="w-full mb-4">
            <div class="h-1 mx-auto gradient w-64 my-0 py-0 rounded-t"></div>
        </div>
        <h3 class="my-4 text-xl leading-tight">
            @lang('Jadilah bagian dari ribuan alumni')
        </h3>
        <div class="py-8">
            <a href="#courses" class="mt-8 mx-auto lg:mx-0 hover:underline bg-red-800 text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                @lang('Daftar')
            </a>
        </div>
        </section>
        @if($popup_image)
        <!-- begin : modal -->
        <div class="fixed z-10 overflow-y-auto top-20 w-full left-0" id="popup">
            <div class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                    <div class="close-popup absolute inset-0 bg-gray-900 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:h-screen">&#8203;</span>
                <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl 
                transform transition-all max-w-4xl sm:my-12 w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <div class="text-black px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <img src="{{ asset('storage/'.$popup_image) }}" class="w-full" />
                        
                        <div class="bg-white px-4 py-3 text-center">
                            <button type="button" class="close-popup py-2 px-4 bg-gray-500 text-white rounded hover:bg-gray-700 mr-2" onclick="togglePopup()">Tutup</button>
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
            var $owl = $(".owl-carousel").owlCarousel({
                items:1,
                loop:true,
                autoplay: true,
                autoplayTimeout:3000,
                animateOut: 'fadeOut',
                nav: false, // We'll use custom nav
                dots: false
            });
            // Custom Navigation Events
            $('.owl-prev').click(function() {
                $owl.trigger('prev.owl.carousel');
            });
            $('.owl-next').click(function() {
                $owl.trigger('next.owl.carousel');
            });
            @if($popup_image)
                    $('.close-popup').click(function(){
                        $('#popup').addClass('hidden')
                    })
            @endif
        });
    </script>
</x-slot>
</x-web-layout>