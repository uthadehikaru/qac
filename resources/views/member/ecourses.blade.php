<x-app-layout>
    <div class="flex flex-wrap place-content-center min-h-48 md:min-h-screen bg-no-repeat bg-cover bg-center" 
    style="background-image: url('{{ asset('images/ecourse-banner.jpg') }}');">
    </div>
    
    @if($order)
    <x-alert type="info">
        Langganan anda aktif mulai dari {{ $order->start_date?->format('d M Y') }} hingga {{ $order->end_date?->format('d M Y') }}.  <a href="{{ route('checkout') }}" class="underline font-bold">Perpanjang sekarang!</a>
    </x-alert>
    @else
    <x-alert type="warning">
        Saat ini anda tidak berlangganan. <a href="{{ route('checkout') }}" class="underline font-bold">Daftar langganan sekarang!</a>
    </x-alert>
    @endif

    <x-panel>
        <div class="flex flex-wrap -m-4">
            @forelse ($ecourses as $ecourse)
            <div class="md:w-1/2 p-4">
                <x-ecourse-card :ecourse="$ecourse" />
            </div>
            @empty
            <div class="text-center">
                Anda belum memiliki akses ke Online Course QAC, <a href="{{ route('ecourses.index') }}" class="text-blue-500 underline font-bold">Daftar Disini</a>
            </div>
            @endforelse
        </div>
    </x-panel>
    
</x-app-layout>