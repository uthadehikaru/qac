<x-web-layout>
    <x-slot name="title"> - Online Course Terbaru QAC</x-slot>
    <section class="mt-20 text-gray-600 body-font overflow-hidden">
    <div class="pt-20">
        <div class="text-center mx-auto">
            <h1 class="sm:text-3xl text-2xl font-medium text-center title-font mb-4">
            Dapatkan Akses ke {{ $ecourses->count() }} Online Courses Sekarang
            </h1>
            <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto">
            Anda berhak mengakses Seluruh Online Courses kami dengan berlangganan hanya <span class="font-bold">@money(\App\Models\System::value('subscription_fee'))/bulan</span>.
            </p>

            
            <div class="flex flex-wrap px-6 justify-center">
                <a href="{{ route('checkout') }}" class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                    Daftar Sekarang
                </a>
            </div>
        </div>
        <div class="-my-8 pt-8 bg-white divide-y-2 divide-gray-100">
            
            @if(session('error'))
                <x-alert type="warning">{{ session('error') }}</x-alert>
            @endif
            <div class="w-3/4 mx-auto">
                <div class="flex flex-wrap -m-4">
                    @foreach ($ecourses as $ecourse)
                    <div class="xl:w-1/3 md:w-1/2 p-4 hover:opacity-75">
                        <a href="{{ route('ecourses.show', $ecourse->slug) }}">
                            <div class="bg-gray-100 p-6 rounded-lg">
                                <img class="h-40 rounded w-full object-cover object-center mb-6" src="{{ $ecourse->imageUrl('thumbnail') }}" alt="content">
                                <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ $ecourse->title }}</h2>
                                <p class="leading-relaxed text-base">{{ $ecourse->description }}</p>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </section>
</x-web-layout>