<x-web-layout>

    <x-panel class="mt-12">
        @if($ecourse->is_only_active_batch)
        <div class="relative py-4 mb-4">
            <button class="filter-nav-custom filter-prev absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-yellow-500 text-white rounded-full p-1 shadow-lg" aria-label="Previous">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="#ffffff">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <div class="overflow-hidden mx-8 border border-yellow-500 py-1 px-2 rounded-full">
                <div class="flex justify-start lg:justify-center filter-carousel transition-transform duration-300 ease-in-out text-black text-xs md:text-base">
                    @foreach($sections as $section)
                    <a href="{{ route('member.ecourses.lessons', [ 'slug' => $ecourse->slug, 'section' => $section->id]) }}" class="px-4 py-2 {{ $video->section_id == $section->id ? 'bg-yellow-500 hover:text-white' : 'hover:bg-yellow-500 hover:text-white' }} rounded-full flex items-center whitespace-nowrap mr-2">{{ $section->name }}</a>
                    @endforeach
                </div>
            </div>
            <button class="filter-nav-custom filter-next absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-yellow-500 text-white rounded-full p-1 shadow-lg" aria-label="Next">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="#ffffff">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        @else
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ $ecourse->level ? route('ecourses.index') : route('event.list') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        {{ $ecourse->level ? 'Program Alumni' : 'Event QAC' }}
                    </a>
                </li>
                @if($ecourse->category)
                <li class="inline-flex items-center">
                    <a href="{{ $ecourse->level ? route('ecourses.index', ['category' => $ecourse->category->slug]) : route('event.list', ['category' => $ecourse->category->slug]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        {{ $ecourse->category->name }}
                    </a>
                </li>
                @endif
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $ecourse->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        @endif
        <div class="container mx-auto">
            <div class="w-full flex flex-col md:flex-row gap-8">
                <div class="content md:w-2/3">
                    @if($video?->getMedia('videos')->first())
                    <video width="100%" height="240" controls controlsList="nodownload">
                    <source src="{{ route('member.ecourses.lessons.video', [$ecourse->slug, $video->lesson_uu]) }}" type="video/mp4">
                    Your browser does not support the video tag.
                    </video>
                    @elseif($video)
                    <img src="{{ $video->imageUrl('thumbnail') }}" alt="No video available" class="w-full h-auto">
                    @else
                    <img src="{{ $ecourse->imageUrl('thumbnail') }}" alt="No video available" class="w-full h-auto">
                    @endif
                   @if($video)
                    <p class="mt-8 font-bold">{{ $video->subject }}</p>
                    <p class="mt-8">{{ $video->description }}</p>
                    <div class="mt-8">
                        <p class="text-lg font-bold ">Download Theory, Workbook & Daily Activities:</p>
                        <ul class="list-decimal pl-4 mt-2">
                        @forelse ($video->getMedia('downloads') as $media)
                            <li class="p-2"><a href="{{ $media->getFullUrl() }}" target="_blank" class="text-red-800">{{ $media->file_name }}</a></li>
                        @empty
                        <p class="text-gray-500">No downloads available</p>
                        @endforelse
                        </ul>
                    </div>
                    @endif
                    @if($videos->count())
                    <h2 class="font-bold text-md my-4">{{ $completed }} of {{ $videos->count() }} Lessons Completed</h2>                    
                    <div class="w-full rounded-full h-2.5 bg-gray-300 mt-2">
                        <div class="bg-red-800 h-2.5 rounded-full" style="width: {{ $videos->count() ? round(($completed/$videos->count())*100):0 }}%"></div>
                    </div>
                    @endif

                </div>
                <div class="md:w-1/3 mt-8 md:mt-0 flex flex-col gap-y-2">
                    @forelse ($videos as $lesson)
                        <x-lesson-card :video="$lesson" :ecourse="$ecourse"
                        :current="$video" />
                    @empty
                    <p class="text-gray-500">Belum ada video yang tersedia</p>
                    @endforelse
                </div>
            </div>
        </div>
</x-panel>
<x-slot name="styles">
    <style>
        .content {
        position: relative;
        margin: 0 auto;
        }
        .content video {
        width: 100%;
        display: block;
        }
        /* .content:before {
        content: '';
        position: absolute;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 5px;
        z-index : 2;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        } */
    </style>
</x-slot>
<x-slot name="scripts">
<script>/*<![CDATA[*/
  $(document).ready(function(){
    document.addEventListener('contextmenu', event => event.preventDefault());
                
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

    // Auto-scroll to selected section when page loads
    function scrollToSelectedSection() {
        const $selectedItem = $filterCarousel.find('a.bg-yellow-500');
        if ($selectedItem.length > 0) {
            const itemWidth = calculateItemWidth();
            const containerWidth = $container.width();
            const selectedIndex = $filterItems.index($selectedItem);
            const selectedPosition = selectedIndex * itemWidth;
            
            // Calculate if the selected item is outside the visible area
            if (selectedPosition < currentPosition || selectedPosition > currentPosition + containerWidth - itemWidth) {
                // Scroll to show the selected item
                currentPosition = Math.max(0, selectedPosition - containerWidth / 2 + itemWidth / 2);
                updateCarousel();
            }
        }
    }

    // Call scroll to selected section after initialization
    setTimeout(scrollToSelectedSection, 100);
  });
/*]]>*/</script>
</x-slot>
</x-web-layout>