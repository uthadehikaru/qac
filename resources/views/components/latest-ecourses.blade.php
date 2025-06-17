<section id="courses" class="bg-gray-100 pt-6 py-8 background"">
    <div class="container mx-auto px-2 pt-4 pb-2 text-gray-800">
        <div class="text-center mb-20">
            <h1 class="text-md md:text-xl font-bold text-center text-gray-900 mb-4">
            Program Alumni QAC
            </h1>
            <div class="w-full mb-4">
            <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
            <p class="lg:w-1/2 w-full leading-relaxed text-gray-100">Terdapat lebih dari 100+ video Tadabbur Al-Qur’an</p>
            </div>
            <div class="flex justify-between border rounded-full p-1 border-yellow-500">
                <a href="#" class="bg-yellow-500 text-white px-4 py-2 rounded-full">Recommended</a>
                <a href="#" class=" px-4 py-2 hover:bg-yellow-500 hover:text-white rounded-full">Tazkiyatun Nafs</a>
                <a href="#" class=" px-4 py-2 hover:bg-yellow-500 hover:text-white rounded-full">Long Life Learning</a>
                <a href="#" class=" px-4 py-2 hover:bg-yellow-500 hover:text-white rounded-full hidden md:block">Tadabbur Pemula</a>
                <a href="#" class=" px-4 py-2 hover:bg-yellow-500 hover:text-white rounded-full hidden md:block">QAC's Tadarus</a>
                <a href="#" class=" px-4 py-2 hover:bg-yellow-500 hover:text-white rounded-full hidden md:block">Coming Soon</a>
            </div>
        </div>
        @if($ecourses->count())
        <div class="flex flex-wrap -m-4">
            @foreach ($ecourses as $ecourse)
            <div class="w-1/2 p-4">
                <a href="{{ route('ecourses.show', $ecourse->slug) }}" title="{{ $ecourse->title }}">
                    <div class="p-6 rounded-lg">
                        <img class="h-40 rounded-lg w-full object-cover object-center mb-6" src="{{ $ecourse->imageUrl('thumbnail') }}" alt="{{ Str::limit($ecourse->title, 50) }}">
                        <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ Str::limit($ecourse->title, 50) }}</h2>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="flex flex-wrap px-6 justify-center">
            <a href="{{ route('ecourses.index') }}" class="mx-auto lg:mx-0 hover:underline bg-red-800 text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                Lihat Semua
            </a>
        </div>
        @else
        <div class="flex justify-center text-white text-2xl"><span>Coming Soon</span></div>
        @endif
    </div>
</section>