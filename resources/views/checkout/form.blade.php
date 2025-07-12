<x-member-layout>

    <section class="bg-white text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-col text-center w-full mb-12">
                <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900 mb-4">Kenapa perlu langganan program Alumni QAC?</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base font-montserrat">Karena kamu mendapatkan <span class="font-bold">rekaman Tadabbur Al-Qur’an setiap juznya dan berbagai benefit lainnya</span>. Yuk simak perbandingan bagan berikut:</p>
                <img src="{{ asset('images/benefit.png') }}" alt="Kenapa perlu langganan program Alumni QAC?" class="w-full md:w-1/2 mx-auto">
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base font-montserrat">Kamu berhak mengakses Seluruh Program Alumni kami dengan berlangganan hanya <span class="font-bold text-black">Rp. 30.000,-/bulan</span> atau setara <span class="font-bold text-black">Rp. 1000,-/hari</span> saja.</p>
                <h1 class="sm:text-3xl text-2xl font-medium title-font text-gray-900 mb-4 uppercase mt-12">Konfirmasi Berlangganan</h1>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base font-montserrat">Langganan kamu akan aktif setelah pembayaran dikonfirmasi</p>
                <p class="lg:w-2/3 mx-auto leading-relaxed text-base mt-12 font-bold text-black">Lama Berlangganan (minimal 1 bulan)</p>
                <form action="{{ route('checkout.store') }}" method="POST" class="mt-4">
                    @csrf
                    <div class="flex flex-col justify-center items-center gap-2">
                        <div class="flex gap-2 items-center">
                            <input type="number" name="months" class="p-2 border border-gray-300 rounded-md">
                            <label for="months" class="text-sm font-bold text-black">Bulan</label>
                        </div>
                        <button type="submit" class="bg-[#7b0c00] text-white font-bold rounded-full my-6 py-2 px-4 text-sm">Daftar Langganan</button>
                    </div>
                </form>
            </div>
        </div>
        <x-whatsapp-button />
    </section>

</x-member-layout>
