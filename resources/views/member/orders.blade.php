<x-member-layout>
    <div class="mt-4 md:mt-8 px-4">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <h1 class="font-bold text-xl mb-4">Lihat semua Transaksi Langganan, kelas hingga sertifikatmu di QAC</h1>
        @foreach ($memberBatches as $memberBatch)
            <div class="flex justify-between my-2 p-4 items-start border border-[#ffdf79] rounded-lg">
                <div class="flex flex-col gap-2">
                    <div class="text-sm font-bold">Kelas {{ $memberBatch->batch->full_name }}</div>
                    @if($memberBatch->approved_at || $memberBatch->status >= 3)
                    <div class="text-xs">Pembayaran pada {{ $memberBatch->approved_at?->format('d M Y') ?? $memberBatch->batch->created_at->format('d M Y') }}</div>
                    @else
                    <div class="text-xs">Menunggu verifikasi pembayaran</div>
                    @endif
                </div>
                <x-qac-button class="text-xs font-bold">@lang('batch.status_'.$memberBatch->status) </x-qac-button>
            </div>
            <div class="flex justify-between my-2 p-4 items-start">
                <p class="text-xs text-gray-500">Sertifikat dapat diunduh setelah kelas {{ $memberBatch->batch->name }} selesai</p>
                @if($memberBatch->file)
                <x-qac-button href="{{ $memberBatch->file->fileUrl('filename') }}" target="_blank">E-Certificate</x-qac-button>
                @else
                <a href="#" class="text-xs font-bold bg-gray-200 text-gray-500 px-4 py-2 rounded-full">E-Certificate</a>
                @endif
            </div>
        @endforeach

        @foreach ($orders as $order)
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
        @endforeach
    </div>
</x-member-layout>