<x-member-layout>

    <section class="bg-white text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="text-xl md:text-3xl font-medium title-font text-gray-900 mb-4">Kenapa perlu berlangganan web qacjakarta.id ?</h1>
                <img src="{{ asset('images/checkout/banner.png') }}" alt="banner qacjakarta.id" class="w-full md:w-2/3 mx-auto my-4">
                <img src="{{ asset('images/checkout/ayah.png') }}" alt="ayah qacjakarta.id" class="w-full md:w-2/3 mx-auto">
                <p class="lg:w-2/3 mx-auto leading-relaxed font-montserrat text-center text-base md:text-2xl italic">"Kitab (Al-Qur`ān) yang Kami turunkan kepadamu penuh berkah agar mereka menghayati ayat-ayatnya dan agar orang-orang yang berakal sehat mendapat pelajaran."</p>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base md:text-2xl font-montserrat mt-4 text-justify">Dengan berlangganan web qacjakarta.id, kamu bisa tiap hari nonton tadabbur sesuai waktu luangmu, secara fleksibel, dan lengkap : ada yang membahas secara <span class="font-bold">global (Surah at Glance), detail (Quality Time with Qur’an), tematik (Free Sharing), motivasi (webinar series)</span> dan masih banyak lagi....</p>
                <p class="lg:w-2/3 lg:mx-auto leading-relaxed text-base md:text-2xl font-montserrat my-4 text-left">Terbagi menjadi <span class="font-bold">3 level</span> :</p>
                <img src="{{ asset('images/checkout/level.png') }}" alt="level qacjakarta.id" class="w-full md:w-2/3 mx-auto">
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base md:text-2xl font-montserrat text-left my-4">Maka bagan berlangganan sebagai berikut:</p>
                <img src="{{ asset('images/checkout/benefit.png') }}" alt="benefit qacjakarta.id" class="w-full md:w-2/3 mx-auto">
                <h1 class="text-xl md:text-3xl font-medium title-font text-gray-900 mb-4 uppercase mt-12">Konfirmasi Berlangganan</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base md:text-2xl font-montserrat">Langganan kamu akan aktif setelah pembayaran dikonfirmasi</p>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base md:text-xl mt-12 font-bold text-black">Lama Berlangganan (minimal 1 bulan)</p>
                <form action="{{ route('checkout.store') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="flex flex-col justify-center items-center gap-2">
                        <div class="flex gap-2 items-center">
                            <input type="number" name="months" class="p-2 border border-gray-300 rounded-md">
                            <label for="months" class="text-base md:text-xl font-bold text-black">Bulan</label>
                        </div>
                        <button type="submit" class="bg-[#7b0c00] text-white font-bold rounded-lg my-6 py-2 px-4 text-xl md:text-3xl">Daftar Langganan</button>
                    </div>
                </form>
            </div>
        </div>
        @if(auth()->check())
        <x-whatsapp-button />
        @endif
    </section>

</x-member-layout>
