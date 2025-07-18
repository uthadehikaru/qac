<x-web-layout>
    <x-slot name="title">
        - QAC 3.0 (Advance Grammar)
    </x-slot>
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center mt-24 px-4 md:px-0">
            <div class="flex flex-col items-center justify-center">
                <img src="{{ asset('images/qac 3/logo.png') }}" alt="QAC 3.0" class="w-full h-auto">
                <img src="{{ asset('images/qac 3/desc.png') }}" alt="QAC 3.0" class="w-full h-auto">
            </div>
            <div class="border-4 border-black rounded-lg">
                <video class="" autoplay muted loop>
                    <source src="{{ asset('storage/sample.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-start mt-24 mx-2">
            <div class="flex flex-col items-center justify-center gap-4">
                <h2 class="text-xl md:text-2xl font-bold text-center rounded-full bg-[#ffdf79] p-2 font-montserrat">Going deeper to Qur’an</h2>
                <p class="text-base md:text-xl font-montserrat">Bagaimana memahami ketika Al-Qur'an <span class="font-bold">keluar dari aturan grammar</span> dan berusaha menelaah <span class="font-bold">pesan-pesan tersembunyi</span>, sehingga <span class="font-bold">kita bisa lebih menikmati</span> membaca Al-Qur'an.</p>
                <img src="{{ asset('images/qac 3/quran.png') }}" alt="Tujuan QAC 3.0" class="w-1/2 h-auto">
            </div>
            <div class="flex flex-col items-center justify-center gap-4">
                <h2 class="text-xl md:text-2xl font-bold text-center mb-4 rounded-full bg-[#ffdf79] p-2 font-montserrat">Advance Nahwu</h2>
                <ul class="flex flex-col gap-4">
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/qac 3/1.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-base md:text-lg font-montserrat">Normal vs Abnormal Sentence</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/qac 3/2.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-base md:text-lg font-montserrat">Perubahan Jumlah dan Gender dalam 1 ayat</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/qac 3/3.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-base md:text-lg font-montserrat">Urutan kata dalam 1 ayat</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/qac 3/4.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-base md:text-lg font-montserrat">Kalimat bersyarat</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/qac 3/5.png') }}" alt="Quote QAC 2.0" class="h-8 w-8">
                        <p class="text-base md:text-lg font-montserrat">Kalimat bertingkat dan sub bagiannya</p>
                    </li>
                </ul>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-24 items-start mt-24 mx-2">
            <div class="rounded-lg bg-[#ffdf79] p-4">
            <h2 class="text-xl font-bold text-center mb-4 underline">Fasilitas apa yang didapatkan?</h2>
                <ul class="flex flex-col gap-4">
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/time.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-base md:text-lg font-montserrat">Kursus 1 sesi persiapan + <span class="font-bold">9 x sesi</span></p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/pdf.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-base md:text-lg font-montserrat">Buku berupa pdf (download di web): <br> <span class="font-bold">Theory, Workbook & Daily Activities</span></p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/video.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-base md:text-lg font-montserrat">Video rangkuman (bisa diakses selama <span class="font-bold">1 bulan setelah kelas</span>) </p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/people.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-base md:text-lg font-montserrat">Semua acara Alumni QAC dan <span class="font-bold">khusus QAC 3.0 (Tadabbur In Depth)</span></p>
                    </li>
                </ul>
            </div>
            <div class="p-4">
                <h2 class="text-xl font-bold text-center mb-4 mt-4 md:mt-0 underline">Teknis (perlu komitmen)</h2>
                <ul class="flex flex-col gap-4">
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/date.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-base md:text-lg font-montserrat">Setiap hari <span class="font-bold">Senin, Rabu dan Jum’at</span>. <br> Sabtu & Ahad libur, selama 9 x.</p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                    <img src="{{ asset('images/icons/clock.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-base md:text-lg font-montserrat">Pilihan : <span class="font-bold">Pagi (8.30)</span> atau <span class="font-bold">Malam (20.00)</span></p>
                    </li>
                    <li class="flex justify-start items-center gap-2">
                        <img src="{{ asset('images/icons/live.png') }}" alt="Quote QAC 3.0" class="h-8 w-8">
                        <p class="text-base md:text-lg font-montserrat"><span class="font-bold">Kelas ONLINE LIVE ZOOM</span> dengan Video persiapan materi yang <span class="font-bold">wajib</span> ditonton <span class="font-bold">sebelum kelas</span></p>
                    </li>
                </ul>
            </div>
        </div>

        <section id="register" class="flex flex-col items-center justify-center mt-12 mb-12">
            <h1 class="w-full my-2 text-xl md:text-3xl font-bold leading-tight text-center text-gray-900">
            Timeline silabus belajar <br> QAC 3.0
            </h1>
            <img src="{{ asset('images/qac 3/silabus.png') }}" alt="Silabus QAC 3.0" class="w-full md:w-1/2 h-auto">
        </section>

        
        <section id="register" class="mx-auto text-center mt-12 mb-12">
            <h1 class="w-full my-2 text-xl md:text-3xl font-bold leading-tight text-center text-gray-900">
                @lang('Bergabung Bersama Para Pejuang')
            </h1>
            <div class="w-full mb-4">
                <x-divider />
            </div>
            <h3 class="my-4 text-base md:text-2xl leading-tight">
                @lang('Khusus Alumni QAC 2.0')
            </h3>
            @if($course)
            <div class="py-8">
                @if($latestBatch)
                <x-register-button href="{{ route('kelas.register',['course_id' => $course->id, 'batch_id' => $latestBatch->id]) }}">
                    @lang('Daftar QAC 3.0')
                </x-register-button>
                @else
                <x-register-button href="{{ route('kelas.register',['course_id' => $course->id]) }}">
                    @lang('Daftar Waitinglist QAC 3.0')
                </x-register-button>
                @endif
            </div>
            @endif
        </section>
    </div>
</x-web-layout>