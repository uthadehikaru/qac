<x-member-layout>
    <div class="m-6">
        <div class="flex flex-wrap -m-4">
            @forelse ($histories as $history)
            <div class="w-full md:w-1/2 p-4">
                <a href="{{ route('member.ecourses.lessons', [$history->lesson->ecourse->slug, $history->lesson->lesson_uu]) }}" class="ecourse" title="{{ $history->lesson->ecourse->title }}">
                    <div class="rounded-lg">
                        <img class="rounded-lg border border-gray-200 w-full h-64 md:h-72 object-cover object-center mb-6"
                        onerror="this.onerror=null; this.src='{{ asset('images/banner.jpg') }}';"
                        src="{{ $history->lesson->ecourse->imageUrl('thumbnail') }}" alt="{{ $history->lesson->ecourse->title }}">
                        <h2 class="text-xs text-gray-900 font-medium title-font mb-2">{{ $history->lesson->subject }}</h2>
                        <p class="text-xs text-gray-500">terakhir ditonton {{ $history->updated_at->diffForHumans() }}</p>
                    </div>
                </a>
            </div>
            @empty
            <div class="text-center">
                Mulai belajar sekarang!
            </div>
            @endforelse
        </div>
        <div class="mt-6">
            {{ $histories->links() }}
        </div>
    </div>
    <x-slot name="scripts">
    @if(!$activeOrder)
    <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="subscriptionModal">
            <div class="flex items-center justify-center min-h-screen">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75"></div>
                <div class="relative bg-white rounded-lg p-8 max-w-lg w-full mx-4">
                    <button class="absolute top-2 right-2 text-gray-500 hover:text-gray-700" onclick="document.getElementById('subscriptionModal').classList.add('hidden')">
                        <img src="{{ asset('images/close.png') }}" alt="Close" class="w-6 h-6">
                    </button>
                    <h3 class="text-xl font-bold mb-4 text-center flex items-center justify-center gap-2"><img src="{{ asset('images/lock.png') }}" alt="Akses Terkunci" class="w-10 h-10 inline-block">Akses Terkunci!!! <img src="{{ asset('images/lock.png') }}" alt="Akses Terkunci" class="w-10 h-10 inline-block"></h3>
                    <p class="text-gray-600 mb-6 text-center">Untuk menonton histori video ini, kamu <span class="font-bold text-black">perlu langganan kembali</span>😊</p>
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
</x-member-layout>