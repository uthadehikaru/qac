<x-web-layout>
    <x-slot name="title"> - Event QAC</x-slot>
    <section class="mt-20 md:mt-24 text-gray-600 body-font overflow-hidden">
        @if($activeOrder)
        <x-active-order :order="$activeOrder" />
        @endif


        <div class="relative py-4">
            <button class="filter-nav-custom filter-prev absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-yellow-500 text-white rounded-full p-1 shadow-lg" aria-label="Previous">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="#ffffff">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <div class="overflow-hidden mx-8 border border-yellow-500 py-1 px-2 rounded-full">
                <div class="flex justify-start lg:justify-center filter-carousel transition-transform duration-300 ease-in-out text-black text-xs md:text-base">
                    @foreach($eventCategories as $category)
                    <a href="{{ route('event.list', ['category' => $category->slug]) }}" class="px-4 py-2 {{ $category->id == $selectedEventCategory->id ? 'bg-yellow-500 hover:text-white' : 'hover:bg-yellow-500 hover:text-white' }} rounded-full flex items-center whitespace-nowrap mr-2">{{ $category->name }}</a>
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
            @forelse($latest_events as $event)
            <div class="w-full md:w-1/3 p-4">
                <a href="{{ route('member.ecourses.lessons', $event->slug) }}" class="ecourse" title="{{ $event->title }}">
                    <div class="rounded-lg">
                        <img class="rounded-lg border border-gray-200 w-full object-cover object-center mb-6" src="{{ $event->imageUrl('thumbnail') }}" alt="{{ $event->title }}"
                        onerror="this.onerror=null; this.src='{{ asset('images/banner.jpg') }}';">
                        <h2 class="text-xs md:text-base text-gray-900 font-medium title-font mb-2">{{ $event->title }}</h2>
                        <p class="text-xs md:text-base text-gray-500">{{ $event->lessons_count }} Videos, {{ $event->ebooks_count }} E-Books</p>
                    </div>
                </a>
            </div>
            @empty
            <div class="w-full text-center p-4 h-64 flex items-center justify-center">
                <p class="text-black font-bold text-xs md:text-base">Segera Hadir Event-Event Baru, Insyaa Allah</p>
            </div>
            @endforelse
        </div>
    </section>
    <x-whatsapp-button />
    <x-slot name="scripts">
    @if(auth()->check() && !$activeOrder)
    <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="subscriptionModal">
            <div class="flex items-center justify-center min-h-screen">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <div class="relative bg-white rounded-lg p-8 max-w-lg w-full mx-4">
                    <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" onclick="document.getElementById('subscriptionModal').classList.add('hidden')">
                        <img src="{{ asset('images/close.png') }}" alt="Close" class="w-6 h-6">
                    </button>
                    <h3 class="text-xl font-bold mb-4 text-center flex items-center justify-center gap-2"><img src="{{ asset('images/lock.png') }}" alt="Akses Terkunci" class="w-10 h-10 inline-block">Akses Terkunci!!! <img src="{{ asset('images/lock.png') }}" alt="Akses Terkunci" class="w-10 h-10 inline-block"></h3>
                    <p class="text-gray-600 mb-6 text-center">Untuk menonton full video ini, kamu <span class="font-bold text-black">perlu langganan</span> agar dapat menikmati <span class="font-bold text-black">rekaman free sharing lainnya 😊</span></p>
                    <div class="flex justify-center gap-4">
                        <x-qac-button href="{{ route('checkout') }}">Langganan Sekarang</x-qac-button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <script>
            jQuery(document).ready(function($){
                $('.ecourse').click(function(e){
                    e.preventDefault();
                    $('#subscriptionModal').removeClass('hidden');
                });
                
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

                // Function to scroll to selected category
                function scrollToSelectedCategory() {
                    const selectedItem = $filterCarousel.find('a.bg-yellow-500');
                    if (selectedItem.length > 0) {
                        const itemWidth = calculateItemWidth();
                        const itemIndex = selectedItem.index();
                        const containerWidth = $container.width();
                        
                        // Calculate position to center the selected item
                        const targetPosition = (itemIndex * itemWidth) - (containerWidth / 2) + (itemWidth / 2);
                        currentPosition = Math.max(0, Math.min(targetPosition, $filterItems.length * itemWidth - containerWidth + 32));
                        
                        updateCarousel();
                    }
                }

                // Initialize carousel
                updateCarousel();
                
                // Scroll to selected category after initialization
                setTimeout(scrollToSelectedCategory, 100);

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
                    // Re-scroll to selected category after resize
                    setTimeout(scrollToSelectedCategory, 100);
                });
            });
    </script>
    </x-slot>
</x-web-layout>