<x-web-layout>
    <x-slot name="title"> - Event Terbaru QAC</x-slot>
    <section class="mt-20 text-gray-600 body-font overflow-hidden">
    <div class="pt-20">
        <div class="text-center mb-20 mx-auto">
            <h1 class="sm:text-3xl text-2xl font-medium text-center title-font mb-4">
            Event Terbaru
            </h1>
            <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto">
            ikuti kegiatan-kegiatan QAC
            </p>
        </div>
        <div class="relative -mt-12 lg:-mt-24 pb-8">
        <svg viewBox="0 0 1428 174" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
            <g transform="translate(-2.000000, 44.000000)" fill="#FFFFFF" fill-rule="nonzero">
                <path d="M0,0 C90.7283404,0.927527913 147.912752,27.187927 291.910178,59.9119003 C387.908462,81.7278826 543.605069,89.334785 759,82.7326078 C469.336065,156.254352 216.336065,153.6679 0,74.9732496" opacity="0.100000001"></path>
                <path
                d="M100,104.708498 C277.413333,72.2345949 426.147877,52.5246657 546.203633,45.5787101 C666.259389,38.6327546 810.524845,41.7979068 979,55.0741668 C931.069965,56.122511 810.303266,74.8455141 616.699903,111.243176 C423.096539,147.640838 250.863238,145.462612 100,104.708498 Z"
                opacity="0.100000001"
                ></path>
                <path d="M1046,51.6521276 C1130.83045,29.328812 1279.08318,17.607883 1439,40.1656806 L1439,120 C1271.17211,77.9435312 1140.17211,55.1609071 1046,51.6521276 Z" id="Path-4" opacity="0.200000003"></path>
            </g>
            <g transform="translate(-4.000000, 76.000000)" fill="#FFFFFF" fill-rule="nonzero">
                <path
                d="M0.457,34.035 C57.086,53.198 98.208,65.809 123.822,71.865 C181.454,85.495 234.295,90.29 272.033,93.459 C311.355,96.759 396.635,95.801 461.025,91.663 C486.76,90.01 518.727,86.372 556.926,80.752 C595.747,74.596 622.372,70.008 636.799,66.991 C663.913,61.324 712.501,49.503 727.605,46.128 C780.47,34.317 818.839,22.532 856.324,15.904 C922.689,4.169 955.676,2.522 1011.185,0.432 C1060.705,1.477 1097.39,3.129 1121.236,5.387 C1161.703,9.219 1208.621,17.821 1235.4,22.304 C1285.855,30.748 1354.351,47.432 1440.886,72.354 L1441.191,104.352 L1.121,104.031 L0.457,34.035 Z"
                ></path>
            </g>
            </g>
        </svg>
        </div>
        <div class="-my-8 pt-12 bg-white divide-y-2 divide-gray-100">
            
            @if(session('error'))
                <x-alert type="warning">{{ session('error') }}</x-alert>
            @endif
            <div class="w-3/4 mx-auto">
                @foreach($latestEvents as $event)
                <div class="py-8 flex flex-wrap md:flex-nowrap">
                    <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                    <span class="font-semibold title-font text-gray-700">{{ $event->event_at->format('d M Y H:i') }}</span>
                    <a href="{{ route('event.detail', $event->slug) }}" class="mt-1">
                        <img class="w-3/4 object-cover object-center" src="{{ $event->imageUrl('thumbnail') }}" alt="{{ $event->title }}">
                    </a>
                    </div>
                    <div class="md:ml-4 md:flex-grow">
                    <h2 class="text-2xl font-medium text-gray-900 title-font mb-2">{{ $event->title }}</h2>
                    
                    <p>{{ $event->course?'Khusus Alumni '.$event->course->name:'Umum' }}</p>
                    <a href="{{ route('event.detail', $event->slug) }}" class="text-indigo-500 inline-flex items-center mt-4">Selengkapnya
                        <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M5 12h14"></path>
                        <path d="M12 5l7 7-7 7"></path>
                        </svg>
                    </a>
                    </div>
                </div>
                @endforeach
                <div class="mt-4 pb-10">
                {{ $latestEvents->links() }}
                </div>
            </div>
        </div>
    </div>
    </section>
</x-web-layout>