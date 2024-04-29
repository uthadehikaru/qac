<x-app-layout>
    <div class="pt-8">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('member.ecourses.index') }}" class="text-blue-500">My Courses</a> / <span class="">Riwayat Langganan</span>
        </div>  
    </div>
    <x-alert type="info">
        Hubungi <a href="https://wa.me/{{ \App\Models\System::value('whatsapp_ecourse') }}?text={{ urlencode('Halo QAC, saya ingin konfirmasi pesanan.') }}" 
        class="underline font-bold px-2" target="_blank"
        >whatsapp admin QAC</a> untuk informasi tata cara pembayaran dan pengiriman bukti transfer
    </x-alert>
    <x-panel>
        <h1 class="font-bold text-xl text-center mb-4">Riwayat Langganan</h1>
            <table class="w-full text-sm md:text-md">
                <tr>
                    <th>Tanggal</th>
                    <th>Harga</th>
                    <th>Jumlah Bulan</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            @forelse ($orders as $order)
                <tr class="my-2">
                    <td class="text-center">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="text-center">@money($order->price)</td>
                    <td class="text-center">{{ $order->months }}</td>
                    <td class="text-center">@money($order->total)</td>
                    <td class="text-center">
                        @if($order->verified_at)
                        {{ $order->is_active?"Aktif":"Inaktif" }} : {{ $order->start_date?->format('d M Y') }} - {{ $order->end_date?->format('d M Y') }}
                        @else
                        Belum dikonfirmasi
                        @endif
                    </td>
                </tr>
            @empty
            <tr class="text-center" colspan="4"><td>
                Anda belum berlangganan Online Course QAC, <a href="{{ route('ecourses.index') }}" class="text-blue-500 underline font-bold">Daftar Disini</a>
                </td></tr>
            @endforelse
            </table>
            {{ $orders->links() }}
    </x-panel>
    
</x-app-layout>