<x-web-layout>
    <div class="flex flex-col lg:flex-row mt-12">
        <div class="w-full lg:w-1/4">
            <x-panel>
                <div class="border rounded-lg p-4 border-[#ffdf79] gap-4">
                    <ul class="flex flex-col gap-2">
                        <li>
                            <a href="{{ route('member.profile') }}" class="flex items-center gap-2 {{ url()->current() == route('member.profile') ? 'bg-[#ffdf79]' : 'hover:bg-[#ffdf79] p-2 rounded-lg' }}  p-2 rounded-lg">
                                <img src="{{ asset('images/icons/user.png') }}" alt="Profil" class="w-6 h-6" />
                                <span class="text-sm font-bold">Profil Saya</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('member.history') }}" class="flex items-center gap-2 {{ url()->current() == route('member.history') ? 'bg-[#ffdf79]' : 'hover:bg-[#ffdf79] p-2 rounded-lg' }}  p-2 rounded-lg">
                                <img src="{{ asset('images/icons/play.png') }}" alt="Histori Video" class="w-6 h-6" />
                                <span class="text-sm font-bold">Histori Video</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('checkout') }}" class="flex items-center gap-2 {{ url()->current() == route('checkout') ? 'bg-[#ffdf79]' : 'hover:bg-[#ffdf79] p-2 rounded-lg' }}  p-2 rounded-lg">
                                <img src="{{ asset('images/icons/cart.png') }}" alt="Daftar Langganan" class="w-6 h-6" />
                                <span class="text-sm font-bold">Daftar Langganan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('member.dashboard') }}" class="flex items-center gap-2 {{ url()->current() == route('member.dashboard') ? 'bg-[#ffdf79]' : 'hover:bg-[#ffdf79] p-2 rounded-lg' }}  p-2 rounded-lg">
                                <img src="{{ asset('images/icons/book.png') }}" alt="Kelas QAC" class="w-6 h-6" />
                                <span class="text-sm font-bold">Kelas QAC</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('member.orders.index') }}" class="flex items-center gap-2 {{ url()->current() == route('member.orders.index') ? 'bg-[#ffdf79]' : 'hover:bg-[#ffdf79] p-2 rounded-lg' }}  p-2 rounded-lg">
                                <img src="{{ asset('images/icons/list.png') }}" alt="Riwayat Transaksi" class="w-6 h-6" />
                                <span class="text-sm font-bold">Riwayat Transaksi</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </x-panel>
        </div>
        <div class="w-full mt-0 lg:mt-12 lg:w-3/4">
            {{ $slot }}
        </div>
    </div>
    @if(isset($scripts))
    <x-slot name="scripts">
        {{ $scripts }}
    </x-slot>
    @endif
</x-web-layout>