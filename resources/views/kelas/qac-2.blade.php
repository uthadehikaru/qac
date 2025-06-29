<x-web-layout>
    <div class="container mx-auto">
        <div class="grid grid-cols-2 gap-4 items-center mt-24">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/qac 2/logo.png') }}" alt="QAC 2.0" class="w-full h-auto">
                <img src="{{ asset('images/qac 2/desc.png') }}" alt="QAC 2.0" class="w-full h-auto">
            </div>
            <img src="{{ asset('images/qac-lite-video.jpg') }}" alt="QAC 2.0" class="w-full h-auto">
        </div>

        <div class="grid grid-cols-2 gap-4 items-start mt-24">
            <div class="flex flex-col items-center justify-center">
                <h2 class="text-sm md:text-xl font-bold text-center mb-4">Tujuannya apa?</h2>
                <img src="{{ asset('images/qac 2/tujuan.png') }}" alt="Tujuan QAC 2.0" class="w-full h-auto">
            </div>
            <div class="flex flex-col justify-center">
                <h2 class="text-sm md:text-xl font-bold text-center mb-4">Apa aja yang akan dibahas?</h2>
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/qac 2/1.png') }}" alt="Tujuan 1 QAC 2.0" class="h-16 w-16">
                    <p class="text-center text-xs md:text-base">Fokus 1 kata dan perubahannya (sharf dasar) tentang Keluarga Keci</p>
                </div>
                <div class="flex items-center justify-center">
                    <p class="text-center text-xs md:text-base">Pendalaman makna, mengupas Keluarga Besar</p>
                    <img src="{{ asset('images/qac 2/2.png') }}" alt="Tujuan 2 QAC 2.0" class="h-16 w-16">
                </div>
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/qac 2/3.png') }}" alt="Tujuan 3 QAC 2.0" class="h-16 w-16">
                    <p class="text-center text-xs md:text-base">Contoh-contoh Tadabbur Al-Qur’an versi QAC 2.0</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 items-start mt-24 mx-2">
            <div class="rounded-lg bg-[#ffdf79] p-4">
                <h2 class="text-sm md:text-xl text-center mb-4">Fasilitas apa yang didapatkan?</h2>
                <ul class="flex flex-col gap-4">
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/time.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Kursus 1 sesi persiapan + 9 x sesi</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/pdf.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Buku berupa pdf (download di web): <br> Theory, Workbook & Daily Activities</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/video.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Video rangkuman (bisa diakses selama 1 bulan setelah kelas) </p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/people.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Acara-acara Alumni QAC (selamanya)</p>
                    </li>
                </ul>
            </div>
            <div class="p-4">
                <h2 class="text-sm md:text-xl text-center mb-4">Teknis (perlu komitmen)</h2>
                <ul class="flex flex-col gap-4">
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/date.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Setiap hari Senin, Rabu dan Jum’at. <br> Sabtu & Ahad libur, selama 9 x.</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/clock.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Pilihan : Pagi (8.30) atau Malam (20.00)</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/live.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Kelas ONLINE LIVE ZOOM dengan Video persiapan materi yang wajib ditonton sebelum kelas</p>
                    </li>
                </ul>
            </div>
        </div>

        <section id="register" class="mx-auto text-center mt-12 mb-12">
            <h1 class="w-full my-2 text-xl md:text-2xl font-bold leading-tight text-center text-gray-900">
            Timeline silabus belajar <br> QAC 2.0
            </h1>
            <img src="{{ asset('images/qac 2/silabus.png') }}" alt="Silabus QAC 2.0" class="w-full h-auto">
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
                @if($latestBatch)
                <a href="{{ route('kelas.register',['course_id' => $course->id, 'batch_id' => $latestBatch->id]) }}" class="mt-8 mx-auto lg:mx-0 hover:underline bg-[#7b0c00] text-white font-bold rounded-lg my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                    @lang('Daftar QAC 2.0')
                </a>
                @else
                <a href="{{ route('kelas.register',['course_id' => $course->id]) }}" class="mt-8 mx-auto lg:mx-0 hover:underline bg-[#7b0c00] text-white font-bold rounded-lg my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                    @lang('Daftar Waitinglist QAC 2.0')
                </a>
                @endif
            </div>
        </section>
    </div>
</x-web-layout>