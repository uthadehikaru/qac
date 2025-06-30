<x-web-layout>
    <x-slot name="title"> - Program Alumni QAC</x-slot>
    <section class="mt-20 text-gray-600 body-font overflow-hidden">
        <div class="relative py-4">
            <button class="filter-nav-custom filter-prev absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-yellow-500 text-white rounded-full p-1 shadow-lg" aria-label="Previous">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="#ffffff">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <div class="overflow-hidden mx-8 border border-yellow-500 py-1 px-2 rounded-full">
                <div class="flex justify-start lg:justify-center filter-carousel transition-transform duration-300 ease-in-out text-black">
                    <a href="{{ route('ecourses.index') }}" class="{{ $selected_category == null ? 'bg-yellow-500 hover:text-white' : 'hover:bg-yellow-500 hover:text-white' }} px-4 py-2 rounded-full flex items-center whitespace-nowrap mr-2 text-xs">Recommended</a>
                    @foreach($categories as $category)
                    <a href="{{ route('ecourses.index', ['category' => $category->slug]) }}" class="px-4 py-2 {{ $category->slug == $selected_category ? 'bg-yellow-500 hover:text-white' : 'hover:bg-yellow-500 hover:text-white' }} rounded-full flex items-center whitespace-nowrap mr-2 text-xs">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>
            <button class="filter-nav-custom filter-next absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-yellow-500 text-white rounded-full p-1 shadow-lg" aria-label="Next">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="#ffffff">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        <div class="flex flex-wrap mx-2">
            @forelse($ecourses as $ecourse)
            <div class="w-full md:w-1/3 p-4">
                <a href="{{ route('ecourses.show', $ecourse->slug) }}" title="{{ $ecourse->title }}">
                    <div class="rounded-lg">
                        <img class="rounded-lg border border-gray-200 w-full object-cover object-center mb-6" src="{{ $ecourse->imageUrl('thumbnail') }}" alt="{{ $ecourse->title }}">
                        <h2 class="text-xs text-gray-900 font-medium title-font mb-2">{{ $ecourse->title }}</h2>
                        <p class="text-xs text-gray-500">{{ $ecourse->lessons_count }} Videos</p>
                    </div>
                </a>
            </div>
            @empty
            <div class="w-full text-center p-4 h-64 flex items-center justify-center">
                <p class="text-black font-bold text-xs md:text-base">Segera Hadir Program-Program Baru, Insyaa Allah</p>
            </div>
            @endforelse
        </div>
    </section>
    <div class="fixed bottom-4 right-4 text-sm flex gap-2 items-center">
        <p>Jika mengalami kendala, silakan hubungi whatsapp kami.</p>
        <a href="https://wa.me/6281234567890" class="bg-green-400 px-4 py-2 rounded-full text-black text-sm">Whatsapp</a>
    </div>
    <x-slot name="scripts">
        <script>
            jQuery(document).ready(function($){
                
                // Filter Carousel functionality
                let currentPosition = 0;
                const $filterCarousel = $('.filter-carousel');
                const $filterItems = $filterCarousel.find('a');
                const $container = $filterCarousel.parent();
                
                // Calculate actual item widths dynamically
                function calculateItemWidth() {
                    return $filterItems.first().outerWidth(true); // Include margin
                }
                
                function updateCarousel() {
                    const itemWidth = calculateItemWidth();
                    const containerWidth = $container.width();
                    const totalWidth = $filterItems.length * itemWidth;
                    const maxPosition = Math.max(0, totalWidth - containerWidth + 32); // Add extra space for padding
                    
                    // Show/hide navigation buttons based on position
                    $('.filter-prev').toggle(currentPosition > 0);
                    $('.filter-next').toggle(currentPosition < maxPosition);
                    
                    // Ensure we don't exceed max position
                    if (currentPosition > maxPosition) {
                        currentPosition = maxPosition;
                    }
                    
                    $filterCarousel.css('transform', `translateX(-${currentPosition}px)`);
                }

                // Initialize carousel
                updateCarousel();

                // Previous button click
                $('.filter-prev').click(function() {
                    if (currentPosition > 0) {
                        const itemWidth = calculateItemWidth();
                        currentPosition = Math.max(0, currentPosition - itemWidth);
                        updateCarousel();
                    }
                });

                // Next button click
                $('.filter-next').click(function() {
                    const itemWidth = calculateItemWidth();
                    const containerWidth = $container.width();
                    const totalWidth = $filterItems.length * itemWidth;
                    const maxPosition = Math.max(0, totalWidth - containerWidth + 32); // Add extra space for padding
                    
                    if (currentPosition < maxPosition) {
                        currentPosition = Math.min(maxPosition, currentPosition + itemWidth);
                        updateCarousel();
                    }
                });

                // Handle window resize
                $(window).resize(function() {
                    updateCarousel();
                });
            });
        </script>
    </x-slot>
</x-web-layout>