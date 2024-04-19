<x-app-layout>
    <div class="flex flex-wrap place-content-center min-h-48 md:min-h-screen bg-no-repeat bg-cover bg-center" 
    style="background-image: url('{{ asset('images/ecourse-banner.jpg') }}');">
    </div>
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
    
    <x-panel>
    <a href="{{ route('member.subscriptions.index') }}" class="text-blue-500">Riwayat Langganan</a> |
    <a href="{{ route('member.orders.index') }}" class="text-blue-500">Riwayat Pesanan</a> |
    <a href="{{ route('ecourses.index') }}" class="text-blue-500">Daftar Online Course</a> |
    </x-panel>
    
</x-app-layout>