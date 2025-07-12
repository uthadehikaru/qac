<x-web-layout>
    <x-slot name="title">
        - QAC 2.0 (Basic Sharf)
    </x-slot>
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center mt-24 px-4 md:px-0">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/qac 2/logo.png') }}" alt="QAC 2.0" class="w-full h-auto">
                <img src="{{ asset('images/qac 2/desc.png') }}" alt="QAC 2.0" class="w-full h-auto">
            </div>
            <div class="border-4 border-black rounded-lg">
                <video class="" autoplay muted loop>
                    <source src="{{ asset('storage/sample.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start mt-24 px-4 md:px-0">
            <div class="flex flex-col items-center justify-center px-4 md:px-0">
                <h2 class="text-2xl md:text-3xl font-bold text-center mb-4">Tujuannya apa?</h2>
                <img src="{{ asset('images/qac 2/tujuan.png') }}" alt="Tujuan QAC 2.0" class="w-full h-auto">
            </div>
            <div class="flex flex-col justify-center px-4 md:px-0 gap-4 md:gap-12">
                <h2 class="text-2xl md:text-3xl font-bold text-center mb-4 md:mb-12">Apa aja yang akan dibahas?</h2>
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/qac 2/1.png') }}" alt="Tujuan 1 QAC 2.0" class="h-48">
                    <p class="text-right text-xl md:text-3xl font-montserrat px-0 md:px-12">Fokus <span class="font-bold">1 kata dan perubahannya</span> (sharf dasar) tentang Keluarga Kecil</p>
                </div>
                <div class="flex items-center justify-center">
                    <p class="text-left text-xl md:text-3xl font-montserrat px-0 md:px-12"><span class="font-bold">Pendalaman makna</span>, mengupas Keluarga Besar</p>
                    <img src="{{ asset('images/qac 2/2.png') }}" alt="Tujuan 2 QAC 2.0" class="h-48">
                </div>
                <div class="flex items-center justify-center">
                    <img src="{{ asset('images/qac 2/3.png') }}" alt="Tujuan 3 QAC 2.0" class="h-48">
                    <p class="text-right text-xl md:text-3xl font-montserrat px-0 md:px-12">Contoh-contoh <span class="font-bold">Tadabbur Al-Qur’an versi QAC 2.0</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-4 items-start mt-24 mx-2 py-0 md:py-8">
            <div class="rounded-lg bg-[#ffdf79] p-4">
                <h2 class="text-2xl text-center mb-4 underline">Fasilitas apa yang didapatkan?</h2>
                <ul class="flex flex-col gap-4">
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/time.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-base font-montserrat">Kursus 1 sesi persiapan + <span class="font-bold">9 x sesi</span></p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/pdf.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-base font-montserrat">Buku berupa pdf (download di web): <br> <span class="font-bold">Theory, Workbook & Daily Activities</span></p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/video.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-base font-montserrat">Video rangkuman <span class="font-bold">(bisa diakses selama 1 bulan setelah kelas)</span> </p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/people.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-base font-montserrat">Acara-acara Alumni QAC <span class="font-bold">(selamanya)</span></p>
                    </li>
                </ul>
            </div>
            <div class="p-4">
                <h2 class="text-xl text-center mb-4 underline">Teknis (perlu komitmen)</h2>
                <ul class="flex flex-col gap-4">
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/date.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-base font-montserrat">Setiap hari <span class="font-bold">Senin, Rabu dan Jum’at</span>. <br> Sabtu & Ahad libur, selama 9 x.</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/clock.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-base font-montserrat">Pilihan : <span class="font-bold">Pagi (8.30)</span> atau <span class="font-bold">Malam (20.00)</span></p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/live.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-base font-montserrat"><span class="font-bold">Kelas ONLINE LIVE ZOOM</span> dengan Video persiapan materi yang <span class="font-bold">wajib</span> ditonton <span class="font-bold">sebelum kelas</span></p>
                    </li>
                </ul>
            </div>
        </div>

        <section id="register" class="flex flex-col items-center justify-center mt-12 mb-12">
            <h1 class="w-full my-2 text-xl md:text-2xl font-bold leading-tight text-center text-gray-900">
            Timeline silabus belajar <br> QAC 2.0
            </h1>
            <img src="{{ asset('images/qac 2/silabus.png') }}" alt="Silabus QAC 2.0" class="w-full md:w-1/2 h-auto">
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