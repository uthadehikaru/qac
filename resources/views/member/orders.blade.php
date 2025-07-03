<x-member-layout>
    <x-panel>
        <h1 class="font-bold text-xl mb-4">Lihat semua Transaksi Langganan, kelas hingga sertifikatmu di QAC</h1>
        @forelse ($orders as $order)
            <div class="flex justify-between my-2 p-4 items-start border border-[#ffdf79] rounded-lg">
                <div class="flex flex-col gap-2">
                    <div class="text-sm font-bold">Langganan Program Alumni {{ $order->months }} bulan</div>
                    @if($order->verified_at)
                    <div class="text-xs">Pembayaran pada {{ $order->verified_at->format('d M Y') }}</div>
                    <div class="text-xs">Langganan aktif hingga {{ $order->end_date?->format('d M Y') }}</div>
                    @else
                    <div class="text-xs">Pemesanan pada {{ $order->created_at->format('d M Y') }}</div>
                    @endif
                </div>
                <x-qac-button class="text-xs font-bold">{{ $order->verified_at ? 'Aktif' : 'Menunggu Konfirmasi' }}</x-qac-button>
            </div>
        @empty
        <div class="text-center">
            Anda belum berlangganan Online Course QAC, <a href="{{ route('checkout') }}" class="text-blue-500 underline font-bold">Daftar Disini</a>
        </div>
        @endforelse
        {{ $orders->links() }}
    </x-panel>
    
</x-member-layout>