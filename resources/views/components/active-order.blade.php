<div class="flex flex-col md:flex-row justify-center items-center gap-x-4 text-xs md:text-base">
    <p class="border border-[#7b0c00] px-4 py-2 mb-4 md:mb-0 text-black">Langganan anda aktif hingga {{ $order->end_date->format('d M Y') }}</p>
    <x-qac-button href="{{ route('checkout') }}">Perpanjang Sekarang</x-qac-button>
</div>