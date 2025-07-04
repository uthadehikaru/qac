<x-web-layout>
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center mt-24">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/qac 3/logo.png') }}" alt="QAC 3.0" class="w-full h-auto">
                <img src="{{ asset('images/qac 3/desc.png') }}" alt="QAC 3.0" class="w-full h-auto">
            </div>
            <img src="{{ asset('images/qac-lite-video.jpg') }}" alt="QAC 3.0" class="w-full h-auto">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start mt-24 mx-2">
            <div class="flex flex-col items-center justify-center gap-4">
                <h2 class="text-sm md:text-xl font-bold text-center rounded-full bg-[#ffdf79] p-2">Going deeper to Qur’an</h2>
                <p class="text-xs md:text-base">Bagaimana memahami ketika Al-Qur’an keluar dari aturan grammar dan berusaha menelaah pesan-pesan tersembunyi, sehingga kita bisa lebih menikmati membaca Al-Qur’an.</p>
                <img src="{{ asset('images/qac 3/quran.png') }}" alt="Tujuan QAC 3.0" class="w-1/2 h-auto">
            </div>
            <div class="flex flex-col justify-center">
            <h2 class="text-sm md:text-xl font-bold text-center mb-4 rounded-full bg-[#ffdf79] p-2">Advance Nahwu</h2>
                <ul class="flex flex-col gap-4">
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/qac 3/1.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Normal vs Abnormal Sentence</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/qac 3/2.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Perubahan Jumlah dan Gender dalam 1 ayat</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/qac 3/3.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Urutan kata dalam 1 ayat</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/qac 3/4.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Kalimat bersyarat</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/qac 3/5.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Kalimat bertingkat dan sub bagiannya</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start mt-24 mx-2">
            <div class="rounded-lg bg-[#ffdf79] p-4">
            <h2 class="text-xs md:text-xl font-bold text-center mb-4">Fasilitas apa yang didapatkan?</h2>
                <ul class="flex flex-col gap-4">
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/time.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Kursus 1 sesi persiapan + 9 x sesi</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/pdf.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Buku berupa pdf (download di web): <br> Theory, Workbook & Daily Activities</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/video.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Video rangkuman (bisa diakses selama 1 bulan setelah kelas) </p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/people.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Semua acara Alumni QAC dan khusus QAC 3.0 (Tadabbur In Depth)</p>
                    </li>
                </ul>
            </div>
            <div class="p-4">
                <h2 class="text-xs md:text-xl text-center mb-4">Teknis (perlu komitmen)</h2>
                <ul class="flex flex-col gap-4">
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/date.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Setiap hari Senin, Rabu dan Jum’at. <br> Sabtu & Ahad libur, selama 9 x.</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/clock.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Pilihan : Pagi (8.30) atau Malam (20.00)</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/live.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-xs md:text-base">Kelas ONLINE LIVE ZOOM dengan Video persiapan materi yang wajib ditonton sebelum kelas</p>
                    </li>
                </ul>
            </div>
        </div>

        <section id="register" class="flex flex-col items-center justify-center mt-12 mb-12">
            <h1 class="w-full my-2 text-xl md:text-2xl font-bold leading-tight text-center text-gray-900">
            Timeline silabus belajar <br> QAC 3.0
            </h1>
            <img src="{{ asset('images/qac 3/silabus.png') }}" alt="Silabus QAC 3.0" class="w-full md:w-1/2 h-auto">
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
                    @lang('Daftar QAC 3.0')
                </a>
                @else
                <a href="{{ route('kelas.register',['course_id' => $course->id]) }}" class="mt-8 mx-auto lg:mx-0 hover:underline bg-[#7b0c00] text-white font-bold rounded-lg my-6 py-4 px-8 shadow-lg focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                    @lang('Daftar Waitinglist QAC 3.0')
                </a>
                @endif
            </div>
        </section>
    </div>
</x-web-layout>