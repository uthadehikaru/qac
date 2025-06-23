<x-web-layout>
    <!--Hero-->
        <div class="pt-16">
            <div class="container-full mx-auto flex flex-wrap flex-col md:flex-row items-center relative">
                <button class="owl-nav-custom owl-prev absolute left-2 top-1/2 transform -translate-y-1/2 z-10 p-2" aria-label="Previous"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="#490d0d"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></button>
                <div class="owl-carousel px-12 py-12" id="banner">
                    @forelse ($banners as $banner)
                    <a href="{{ $banner->url }}" class="w-full text-center"><img class="rounded-lg" src="{{ $banner->imageUrl('image') }}" /></a>
                    @empty
                    <div class="w-full text-center"><img src="{{ asset('images/banner.jpg') }}" /></div>
                    @endforelse
                </div>
                <button class="owl-nav-custom owl-next absolute right-2 top-1/2 transform -translate-y-1/2 z-10 p-2" aria-label="Next"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="#490d0d"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></button>
            </div>
        </div>

        <section id="why" class="bg-white py-8">
            <div class="container max-w-5xl mx-auto m-8">
                <h1 class="w-full my-2 text-base md:text-2xl font-bold leading-tight text-center text-gray-800">
                {{ $why1->value }}
                </h1>
                <div class="w-full mb-4">
                    <x-divider />
                </div>
                <div class="flex flex-wrap justify-center">
                    <video width="400" height="800" class="border border-gray-300 border-8 rounded-lg" controls controlsList="nodownload">
                        <source src="{{ asset('apa itu qac.mp4') }}" type="video/mp4">
                    </video>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-2 gap-4">
            <section id="introduction" class="bg-white py-8">
            <div class="container max-w-5xl mx-auto m-8">
                <h1 class="w-full my-2 text-xs md:text-2xl font-bold leading-tight text-center text-gray-800">
                Yuk, kenali QAC!
                </h1>
                <div class="w-full mb-4">
                    <x-divider />
                </div>
                <div class="flex flex-wrap justify-center">
                    <img src="{{ asset('images/introduction.png') }}" />
                </div>
            </div>
            </section>
            <section id="howto" class="bg-white py-8">
            <div class="container max-w-5xl mx-auto m-8">
                <h1 class="w-full my-2 text-xs md:text-2xl font-bold leading-tight text-center text-gray-800">
                Bagaimana metode belajarnya?
                </h1>
                <div class="w-full mb-4">
                    <x-divider />
                </div>
                <div class="flex flex-wrap justify-center">
                    <img src="{{ asset('images/howto.png') }}" />
                </div>
            </div>
            </section>
        </div>

        <section id="courses" class="pt-6 py-8">
        <div class="container mx-auto px-2 pt-4 pb-2 text-gray-800">
            <div class="text-center mb-8">
                <h1 class="text-md md:text-2xl font-bold text-center text-gray-900 mb-4">
                Kelas QAC
                </h1>
                <div class="w-full mb-4">
                <x-divider />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="">
                    <div class="h-full border-2 align-center border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                        <div class="">
                            <a href="#" class="">
                                <img class="w-full object-cover object-center" 
                                src="{{ asset('images/qac lite.png') }}" alt="QAC Lite" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="h-full border-2 align-center border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                        <div class="">
                            <a href="#" class="">
                                <img class="w-full object-cover object-center" 
                                src="{{ asset('images/qac 1.png') }}" alt="QAC 1" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="h-full border-2 align-center border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                        <div class="">
                            <a href="#" class="">
                                <img class="w-full object-cover object-center" 
                                src="{{ asset('images/qac 2.png') }}" alt="QAC 2" />
                            </a>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="h-full border-2 align-center border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                        <div class="">
                            <a href="#" class="">
                                <img class="w-full object-cover object-center" 
                                src="{{ asset('images/qac 3.png') }}" alt="QAC 3" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>

        <section id="courses" class="pt-6 py-8">
            <div class="container mx-auto px-2 pt-4 pb-2 text-gray-800">
                <div class="text-center mb-8">
                    <h1 class="text-md md:text-xl font-bold text-center text-gray-900 mb-4">
                    Program Alumni QAC
                    </h1>
                    <div class="w-full mb-4">
                    <x-divider />
                    <p class="w-full leading-relaxed text-xs mt-4">Terdapat lebih dari 100+ video Tadabbur Al-Qur'an</p>
                    </div>
                    <div class="flex justify-between border rounded-full text-xs p-1 border-yellow-500">
                        <a href="#" class="bg-yellow-500 hover:text-white px-4 py-2 rounded-full flex items-center">Recommended</a>
                        <a href="#" class="px-4 py-2 hover:bg-yellow-500 hover:text-white rounded-full flex items-center">Tazkiyatun Nafs</a>
                        <a href="#" class="px-4 py-2 hover:bg-yellow-500 hover:text-white rounded-full flex items-center">Long Life Learning</a>
                        <a href="#" class="px-4 py-2 hover:bg-yellow-500 hover:text-white rounded-full hidden md:block flex items-center">Tadabbur Pemula</a>
                        <a href="#" class="px-4 py-2 hover:bg-yellow-500 hover:text-white rounded-full hidden md:block flex items-center">QAC's Tadarus</a>
                        <a href="#" class="px-4 py-2 hover:bg-yellow-500 hover:text-white rounded-full hidden md:block flex items-center">Coming Soon</a>
                    </div>
                </div>
                <div class="flex flex-wrap -m-4">
                    <div class="w-1/2 p-4">
                        <a href="#" title="Quality Time with Qur'an">
                            <div class="rounded-lg">
                                <img class="rounded-lg w-full object-cover object-center mb-6" src="{{ asset('images/program alumni 2.png') }}" alt="program alumni 1">
                                <h2 class="text-xs text-gray-900 font-medium title-font mb-2">Quality Time with Qur'an</h2>
                                <p class="text-xs text-gray-500">164 Videos</p>
                            </div>
                        </a>
                    </div>
                    
                    <div class="w-1/2 p-4">
                        <a href="#" title="Tadarus Ramadhan 'Redefinition'">
                            <div class="rounded-lg">
                                <img class="rounded-lg w-full object-cover object-center mb-6" src="{{ asset('images/program alumni 1.png') }}" alt="program alumni 2">
                                <h2 class="text-xs text-gray-900 font-medium title-font mb-2">Tadarus Ramadhan "Redefinition"</h2>
                                <p class="text-xs text-gray-500">164 Videos</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap px-6 justify-center">
                    <x-qac-button href="{{ route('ecourses.index') }}">Lihat Semua</x-qac-button>
                </div>
            </div>
        </section>

        <section id="events" class="bg-white text-gray-600 body-font pt-12">
            <div class="container px-5 py-2 mx-auto">
                <div class="text-center mb-8">
                    <h1 class="text-base md:text-xl font-bold text-center title-font text-gray-900 mb-4">
                    Event QAC
                    </h1>
                    <div class="w-full mb-4">
                        <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
                    </div>
                    <p class="text-xs md:text-xl leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto">
                    Kegiatan atau program yang terbuka untuk UMUM
                    </p>
                    <div class="flex justify-between border rounded-full text-xs p-1 border-yellow-500">
                        <a href="#" class="bg-yellow-500 hover:text-white px-4 py-2 rounded-full flex items-center">Free Sharing</a>
                        <a href="#" class="px-4 py-2 hover:bg-yellow-500 hover:text-white rounded-full flex items-center">Ngobrolin Qur'an</a>
                        <a href="#" class="px-4 py-2 hover:bg-yellow-500 hover:text-white rounded-full flex items-center">E-Book</a>
                    </div>
                </div>
                <div class="flex flex-wrap -m-4">
                    <div class="w-1/2 p-4">
                        <a href="#" title="Quality Time with Qur'an">
                            <div class="rounded-lg">
                                <img class="rounded-lg w-full object-cover object-center mb-6" src="{{ asset('images/event 1.png') }}" alt="event 1">
                                <h2 class="text-xs text-gray-900 font-medium title-font mb-2">Embrace The Spirit of Ramadhan</h2>
                                <p class="text-xs text-gray-500">6 Videos, 6 E-Books</p>
                            </div>
                        </a>
                    </div>
                    
                    <div class="w-1/2 p-4">
                        <a href="#" title="Tadarus Ramadhan 'Redefinition'">
                            <div class="rounded-lg">
                                <img class="rounded-lg w-full object-cover object-center mb-6" src="{{ asset('images/event 2.png') }}" alt="program alumni 2">
                                <h2 class="text-xs text-gray-900 font-medium title-font mb-2">Special Persiapan Malam Lailatul Qadr</h2>
                                <p class="text-xs text-gray-500">3 Videos, 3 E-Books</p>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="flex flex-wrap px-6 justify-center">
                    <x-qac-button href="{{ route('event.list') }}">Lihat Semua</x-qac-button>
                </div>
            </div>
        </section>

        <section id="testimonial-section" class="text-gray-600 body-font relative">
            <div class="container px-5 py-8 mx-auto">
                <h1 class="w-full my-2 text-base font-bold leading-tight text-center text-gray-900">
                    @lang('Apa Kata Alumni QAC?')
                </h1>
                <div class="w-full mb-4">
                    <div class="h-1 mx-auto gradient w-64 my-0 py-0 rounded-t"></div>
                </div>
                <button class="owl-nav-custom testimonial-prev absolute left-1 top-1/2 transform -translate-y-1/2 z-10 p-2" aria-label="Previous"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="#490d0d"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg></button>
                <div class="owl-carousel px-4 py-4" id="testimonial">
                    <div class="w-full lg:mb-0 p-4 bg-[#fff9e4] rounded-lg">
                        <div class="h-full text-center">
                        <p class="text-gray-800 text-sm font-bold my-3">QAC 2.2 Batch 2</p>
                        <p class="leading-relaxed text-gray-600 text-center text-xs">
                        Alhamdulillah bisa berkesempatan lanjut ikut QAC
                        2.2. Jikalau ikut dari awal sampai tingkat ini, pasti
                        berasa sekali bahwa pembelajarannya benar-benar
                        disusun sedemikian rupa sehingga mudah untuk
                        dicerna, darimana pun background-nya.
                        </p>
                        <span class="inline-block h-1 w-24 rounded bg-[#e9a621] mt-6 mb-4"></span>
                        <p class="text-gray-800 text-sm font-bold">Aisha Shannaz</p>
                        </div>
                    </div>
                    @foreach($testimonials as $testimonial)
                    <div class="w-full lg:mb-0 p-4 bg-[#fff9e4] rounded-lg">
                        <div class="h-full text-center">
                        <p class="text-gray-800 text-sm font-bold my-3">{{ $testimonial->batch->full_name }}</p>
                        <p class="leading-relaxed text-gray-600 text-center text-xs">
                            {!! nl2br(substr($testimonial->testimonial,0,500)) !!} ...
                        </p>
                        <span class="inline-block h-1 w-24 rounded gradient mt-6 mb-4"></span>
                        <p class="text-gray-800 text-sm font-bold">{{ $testimonial->member->full_name }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button class="owl-nav-custom testimonial-next absolute right-1 top-1/2 transform -translate-y-1/2 z-10 p-2" aria-label="Next"><svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="#490d0d"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg></button>
                <div class="flex flex-wrap px-6 justify-center">
                    <x-qac-button href="{{ route('testimonials') }}">Lihat Semua</x-qac-button>
                </div>
            </div>
        </section>
        <section id="register" class="mx-auto text-center mt-12 mb-12">
        <h1 class="w-full my-2 text-base font-bold leading-tight text-center text-gray-900">
            @lang('Bergabung Bersama Para Pejuang')
        </h1>
        <div class="w-full mb-4">
            <div class="h-1 mx-auto gradient w-64 my-0 py-0 rounded-t"></div>
        </div>
        <h3 class="my-4 text-xs leading-tight">
            @lang('Jadilah bagian dari ribuan alumni')
        </h3>
        <div class="py-8">
            <x-qac-button href="{{ route('register') }}">Daftar</x-qac-button>
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
                            <x-qac-button href="javascript:void(0)" class="close-popup" onclick="togglePopup()">Tutup</x-qac-button>
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
            var $owl = $("#banner").owlCarousel({
                items:1,
                loop:true,
                autoplay: true,
                autoplayTimeout:3000,
                animateOut: 'fadeOut',
                nav: false, // We'll use custom nav
                dots: false,
                autoHeight: true
            });
            // Custom Navigation Events
            $('.owl-prev').click(function() {
                $owl.trigger('prev.owl.carousel');
            });
            $('.owl-next').click(function() {
                $owl.trigger('next.owl.carousel');
            });
            var $testimonialowl = $("#testimonial").owlCarousel({
                items:1,
                loop:false,
                autoHeight: true
            });
            $('.testimonial-prev').click(function() {
                $testimonialowl.trigger('prev.owl.carousel');
            });
            $('.testimonial-next').click(function() {
                $testimonialowl.trigger('next.owl.carousel');
            });
        });
    </script>
    
    @if($popup_image)
    <script>
        jQuery(document).ready(function($){
            $('.close-popup').click(function(){
                $('#popup').addClass('hidden')
            });
        });
    </script>
    @endif
</x-slot>
</x-web-layout>