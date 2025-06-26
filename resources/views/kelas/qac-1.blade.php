<x-web-layout>
    <div class="container mx-auto">
        <div class="grid grid-cols-2 gap-4 items-center mt-24">
            <img src="{{ asset('images/qac-1.jpeg') }}" alt="QAC 1.0" class="w-full h-auto">
            <img src="{{ asset('images/qac-lite-video.jpg') }}" alt="QAC 1.0" class="w-full h-auto">
        </div>

        <div class="grid grid-cols-2 gap-4 items-start mt-24">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/qac 1/quote.png') }}" alt="Quote QAC 1.0" class="w-full h-auto">
                <img src="{{ asset('images/qac 1/quote image.png') }}" alt="Quote QAC 1.0" class="w-full h-auto">
            </div>
            <div class="flex flex-col justify-center">
                <h2 class="text-sm md:text-xl font-bold text-center mb-4">Apa aja yang akan dibahas?</h2>
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/qac 1/1.png') }}" alt="Quote QAC 1.0" class="w-1/2 h-auto">
                    <p class="text-center text-xs md:text-base">Fondasi Bahasa Arab Al-Qur’an</p>
                </div>
                <div class="flex items-center justify-center">
                    <p class="text-center text-xs md:text-base">Tata Bahasa Arab Al-Qur’an dasar</p>
                    <img src="{{ asset('images/qac 1/2.png') }}" alt="Quote QAC 1.0" class="w-1/2 h-auto">
                </div>
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/qac 1/3.png') }}" alt="Quote QAC 1.0" class="w-1/2 h-auto">
                    <p class="text-center text-xs md:text-base">Persiapan ke level selanjutnya (QAC 2.0)</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 items-start mt-24 mx-2">
            <div class="rounded-lg bg-[#ffdf79] p-4">
                <h2 class="text-sm md:text-xl text-center mb-4">Apa aja yang akan dibahas?</h2>
                <ul class="flex flex-col gap-4">
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/time.png') }}" alt="Quote QAC 1.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Kursus 1 sesi persiapan + 15 x sesi</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/pdf.png') }}" alt="Quote QAC 1.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Buku berupa pdf (download di web): <br> Theory, Workbook & Daily Activities</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/video.png') }}" alt="Quote QAC 1.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Video rangkuman (bisa diakses selama 1 bulan setelah kelas) </p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/people.png') }}" alt="Quote QAC 1.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Acara-acara Alumni QAC (selamanya)</p>
                    </li>
                </ul>
            </div>
            <div class="p-4">
                <h2 class="text-sm md:text-xl text-center mb-4">Teknis (perlu komitmen)</h2>
                <ul class="flex flex-col gap-4">
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/date.png') }}" alt="Quote QAC 1.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Setiap hari berturut-turut @1 jam : <br>
                            Senin s/d Jum’at. Sabtu & Ahad libur, selama 16 x.</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/clock.png') }}" alt="Quote QAC 1.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Pilihan : Pagi (8.30) atau Malam (20.00)</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/live.png') }}" alt="Quote QAC 1.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Kelas ONLINE LIVE ZOOM dengan Video persiapan materi yang wajib ditonton sebelum kelas</p>
                    </li>
                </ul>
            </div>
        </div>

        <section id="register" class="mx-auto text-center mt-12 mb-12">
            <h1 class="w-full my-2 text-xl md:text-2xl font-bold leading-tight text-center text-gray-900">
            Timeline silabus belajar <br> QAC 1.0
            </h1>
            <img src="{{ asset('images/qac 1/silabus.png') }}" alt="Silabus QAC 1.0" class="w-full h-auto">
        </section>

        
        <section id="register" class="mx-auto text-center mt-12 mb-12">
            <h1 class="w-full my-2 text-xl md:text-2xl font-bold leading-tight text-center text-gray-900">
                @lang('Bergabung Bersama Para Pejuang')
            </h1>
            <div class="w-full mb-4">
                <x-divider />
            </div>
            <h3 class="my-4 text-base md:text-2xl leading-tight">
                @lang('Jadilah bagian dari ribuan alumni')
            </h3>
            <div class="py-8">
                <a href="#" class="mt-8 mx-auto lg:mx-0 hover:underline bg-[#7b0c00] text-white font-bold rounded-lg my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                    @lang('Daftar QAC 1.0')
                </a>
            </div>
        </section>
    </div>
</x-web-layout>