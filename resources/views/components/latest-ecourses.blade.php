<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap w-full mb-20">
        <div class="lg:w-1/2 w-full mb-6 lg:mb-0">
            <h1 class="sm:text-3xl text-2xl font-medium title-font mb-2 text-white">Online Courses</h1>
            <div class="h-1 w-20 bg-indigo-500 rounded"></div>
        </div>
        <p class="lg:w-1/2 w-full leading-relaxed text-gray-100">Whatever cardigan tote bag tumblr hexagon brooklyn asymmetrical gentrify, subway tile poke farm-to-table. Franzen you probably haven't heard of them man bun deep jianbing selfies heirloom prism food truck ugh squid celiac humblebrag.</p>
        </div>
        <div class="flex flex-wrap -m-4">
            @foreach ($ecourses as $ecourse)
            <div class="xl:w-1/4 md:w-1/2 p-4">
                <a href="{{ route('ecourses.show', $ecourse->slug) }}">
                    <div class="bg-gray-100 p-6 rounded-lg">
                        <img class="h-40 rounded w-full object-cover object-center mb-6" src="{{ $ecourse->imageUrl('thumbnail') }}" alt="content">
                        <h3 class="tracking-widest text-indigo-500 text-xs font-medium title-font">Category</h3>
                        <h2 class="text-lg text-gray-900 font-medium title-font mb-4">{{ $ecourse->title }}</h2>
                        <p class="leading-relaxed text-base">{{ $ecourse->description }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="flex flex-wrap px-6 justify-center">
            <a href="{{ route('ecourses.index') }}" class="mx-auto lg:mx-0 hover:underline bg-white text-grey-500 font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                Lihat Semua
            </a>
        </div>
    </div>
</section>