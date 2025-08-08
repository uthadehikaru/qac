<x-web-layout>
<section id="faq" class="bg-white pt-24 text-gray-700">
    <div class="container px-5 mx-auto">
        <img src="{{ asset('images/donasi banner.png') }}" alt="Donasi Banner" class="w-full md:w-2/3 mx-auto">
        <p class="text-black text-base md:text-xl text-justify w-full md:w-2/3 mx-auto">Donasi ini akan dipakai untuk <span class="font-bold">mendukung kegiatan-kegiatan QAC</span>. 
        Kegiatan kami seputar <span class="font-bold text-justify">pemberdayaan muslim</span> dan <span class="font-bold">membaca Al-Qur'an sampai tadabbur bahasa Arabnya</span>. Kami berharap dengan setiap hari terpapar tadabbur Al-Qur'an akan berpengaruh kepada hati dan perilaku sehari-hari.</p>
        <p class="pt-12 text-center w-full text-base md:text-xl">Donasi via :</p>
        <a href="https://wa.me/{{ \App\Models\System::value('whatsapp_ecourse') }}" target="_blank" class="flex justify-center"><img src="{{ asset('images/waadmin.png') }}" alt="WA Admin QAC" class="w-1/2 md:w-1/3"></a>
        <img src="{{ asset('images/donasi quote.png') }}" alt="Donasi Quote" class="w-full md:w-1/2 mx-auto">
    </div>
</section>
</x-web-layout>