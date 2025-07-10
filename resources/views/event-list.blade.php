<x-web-layout>
    <x-slot name="title"> - Event QAC</x-slot>
    <section class="mt-20 text-gray-600 body-font overflow-hidden">
        @if($activeOrder)
        <x-active-order :order="$activeOrder" />
        @endif


        <div class="relative py-4">
            <div class="overflow-hidden mx-8 border border-yellow-500 py-1 px-2 rounded-full">
                <div class="flex justify-between lg:justify-center filter-carousel transition-transform duration-300 ease-in-out text-black text-xs md:text-base">
                    @foreach($eventCategories as $category)
                    <a href="{{ route('event.list', ['category' => $category->slug]) }}" class="px-4 py-2 {{ $category->id == $selectedEventCategory->id ? 'bg-yellow-500 hover:text-white' : 'hover:bg-yellow-500 hover:text-white' }} rounded-full flex items-center whitespace-nowrap mr-2">{{ $category->name }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="flex flex-wrap mx-2">
            @forelse($latest_events as $event)
            <div class="w-full md:w-1/3 p-4">
                <a href="{{ route('member.ecourses.lessons', $event->slug) }}" class="ecourse" title="{{ $event->title }}">
                    <div class="rounded-lg">
                        <img class="rounded-lg border border-gray-200 w-full object-cover object-center mb-6" src="{{ $event->imageUrl('thumbnail') }}" alt="{{ $event->title }}">
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
    <script>
            jQuery(document).ready(function($){
                $('.ecourse').click(function(e){
                    e.preventDefault();
                    $('#subscriptionModal').removeClass('hidden');
                });
            });
    </script>
    @endif
    </x-slot>
</x-web-layout>