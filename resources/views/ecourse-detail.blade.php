<x-web-layout>
    <x-slot name="title"> - Online Course {{ $ecourse->title }}</x-slot>
    <section class="mt-20 bg-white text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-24 mx-auto">
            <div class="lg:w-4/5 mx-auto flex flex-wrap">
            <img alt="{{ $ecourse->title }}" class="lg:w-1/2 w-full lg:h-auto h-64 object-contain object-center rounded" src="{{ $ecourse->imageUrl('thumbnail') }}">
            <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                <h2 class="text-sm title-font text-gray-500 tracking-widest">{{ $ecourse->created_at->format('d M Y H:i') }}</h2>
                <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ $ecourse->title }}</h1>
                <div class="flex mb-4">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                        </svg>{{ $ecourse->views }}
                    </span>
                    <span class="flex ml-3 pl-3 py-2 border-l-2 border-gray-200 space-x-2s">
                        bagikan :
                        <a title="bagikan ke facebook" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('ecourses.show',$ecourse->slug)) }}&quote={{ urlencode('Yuk ikutan ecourse QAC bersama saya') }}" class="text-gray-500" target="_blank">
                        <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                        </svg>
                        </a>
                        <a title="bagikan ke twitter" href="https://twitter.com/intent/tweet?url={{ urlencode(route('ecourses.show',$ecourse->slug)) }}&text={{ urlencode('Yuk ikutan ecourse QAC bersama saya') }}" class="ml-2 text-gray-500" target="_blank">
                        <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
                        </svg>
                        </a>
                        <a title="bagikan ke whatsapp" href="https://wa.me/?text={{ urlencode('Yuk ikutan online course QAC Bersama saya. '.route('ecourses.show',$ecourse->slug)) }}" class="ml-2 text-gray-500" target="_blank">
                        <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        </a>
                    </span>
                </div>
                <p class="leading-relaxed mt-2">{!! nl2br($ecourse->description) !!}</p>
            </div>
            </div>
        </div>
    </section>
    <section id="ecourses" class="bg-white text-gray-600 body-font">
        <div class="container px-5 py-2 mx-auto">
            <div class="text-center mb-20">
                <h1 class="sm:text-3xl text-2xl font-medium text-center title-font text-gray-900 mb-4">
                Online Course mendatang lainnya
                </h1>
            </div>
            <div class="flex flex-wrap -m-4">
                @foreach($ecourses as $ecourse)
                <div class="p-4 md:w-1/3">
                    <div class="h-full border-2 border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                        <img class="w-full object-cover object-center" src="{{ $ecourse->imageUrl('thumbnail') }}" alt="{{ $ecourse->title }}">
                        <div class="p-6">
                            <h2 class="tracking-widest text-xs title-font font-medium text-gray-400 mb-1">{{ $ecourse->created_at->format('d M Y H:i') }}</h2>
                            <h1 class="title-font text-lg font-medium text-gray-900 mb-3">{{ $ecourse->title }}</h1>
                            <div class="flex items-center flex-wrap ">
                                <a href="{{ route('ecourses.show', $ecourse->slug) }}" class="text-indigo-500 inline-flex items-center md:mb-2 lg:mb-0">Selengkapnya
                                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M5 12h14"></path>
                                    <path d="M12 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                                <span class="text-gray-400 mr-3 inline-flex items-center lg:ml-auto md:ml-0 ml-auto leading-none text-sm py-1">
                                    <svg class="w-4 h-4 mr-1" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                    </svg>{{ $ecourse->views }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="flex flex-wrap px-6 justify-center">
                <a href="{{ route('ecourses.index') }}" class="mx-auto lg:mx-0 hover:underline gradient text-white font-bold rounded-full my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                    Lihat Online Course Lainnya
                </a>
            </div>
        </div>
    </section>
</x-web-layout>