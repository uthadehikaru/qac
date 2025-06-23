<x-web-layout>
    <div class="container mx-auto">
        <div class="grid grid-cols-2 gap-4 items-center mt-24">
            <img src="{{ asset('images/qac-2.jpeg') }}" alt="QAC 1.0" class="w-full h-auto">
            <img src="{{ asset('images/qac-lite-video.jpg') }}" alt="QAC 1.0" class="w-full h-auto">
        </div>

        
        <section id="register" class="mx-auto text-center mt-12 mb-12">
            <h1 class="w-full my-2 text-xl md:text-2xl font-bold leading-tight text-center text-gray-900">
                @lang('Bergabung Bersama Para Pejuang')
            </h1>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-64 my-0 py-0 rounded-t"></div>
            </div>
            <h3 class="my-4 text-base md:text-2xl leading-tight">
                @lang('Jadilah bagian dari ribuan alumni')
            </h3>
            <div class="py-8">
                <a href="#" class="mt-8 mx-auto lg:mx-0 hover:underline bg-[#7b0c00] text-white font-bold rounded-lg my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                    @lang('Daftar QAC 2.0')
                </a>
            </div>
        </section>
    </div>
</x-web-layout>