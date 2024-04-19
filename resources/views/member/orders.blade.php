<x-app-layout>
    <div class="pt-8">
        <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
            <a href="{{ route('member.ecourses.index') }}" class="text-blue-500">My Courses</a> / <span class="">Riwayat Pesanan</span>
        </div>  
    </div>
    <x-alert type="info">
        Hubungi <a href="https://wa.me/{{ \App\Models\System::value('whatsapp') }}?text={{ urlencode('Halo QAC, saya ingin konfirmasi pesanan.') }}" 
        class="underline font-bold px-2" target="_blank"
        >whatsapp admin QAC</a> untuk informasi tata cara pembayaran dan pengiriman bukti transfer
    </x-alert>
    <x-panel>
        <h1 class="font-bold text-xl text-center mb-4">Riwayat Pesanan</h1>
            <table class="w-full">
                <tr>
                    <th>Tanggal</th>
                    <th>Course</th>
                    <th>Harga</th>
                    <th>Jumlah Bulan</th>
                    <th>Total</th>
                    <th>Tgl Konfirmasi</th>
                </tr>
            @forelse ($orders as $order)
                <tr class="my-2">
                    <td class="text-center">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="text-center"><a href="{{ route('ecourses.show', $order->ecourse->slug) }}" class="underline font-bold">{{ $order->ecourse->title }}</a></td>
                    <td class="text-center">@money($order->price)</td>
                    <td class="text-center">{{ $order->months }}</td>
                    <td class="text-center">@money($order->total)</td>
                    <td class="text-center">{{ $order->verified_at?->format('d M Y H:i') ?? 'Belum Dikonfirmasi' }}</td>
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