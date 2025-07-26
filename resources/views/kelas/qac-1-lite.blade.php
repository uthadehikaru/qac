<x-web-layout>
    <x-slot name="title">
        - QAC 1.0 Lite (Self Paced)
    </x-slot>
    <div class="container mx-auto mt-24">
        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif
        <img src="{{ asset('images/qac lite/logo.png') }}" alt="QAC 1.0 Lite" class="w-2/3 md:w-1/2 mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center mt-4 px-2">
            <div class="border-4 border-black rounded-lg">
                <video class="" controls controlsList="nodownload">
                    <source src="{{ asset('storage/sample.mp4') }}" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
            <div class="flex justify-center">
                <img src="{{ asset('images/qac lite/quote lite.png') }}" alt="QAC 1.0 Lite" class="w-full h-auto">
            </div>
        </div>

        <div class="py-4 md:py-24 px-4 md:px-0">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 md:gap-4 items-top font-montserrat">
                <!-- Left Column -->
                <div class="px-1 md:px-4">
                    <h2 class="text-xl md:text-2xl mb-4">Belajar <strong class="font-bold">esensi</strong> bahasa Arab Al-Qur'an sampai tadabbur.</h2>
                    <ul class="space-y-4 text-base md:text-2xl">
                        <li class="flex items-center">
                        <img src="{{ asset('images/qac lite/check.png') }}" alt="QAC 1.0 Lite" class="h-12 md:h-24 mr-2"/>
                            <span class="italic">Sesuai pacemu</span>
                        </li>
                        <li class="flex items-center">
                            <img src="{{ asset('images/qac lite/check.png') }}" alt="QAC 1.0 Lite" class="h-12 md:h-24 mr-2"/>
                            <span class="italic">Dimanapun</span>
                        </li>
                        <li class="flex items-center">
                            <img src="{{ asset('images/qac lite/check.png') }}" alt="QAC 1.0 Lite" class="h-12 md:h-24 mr-2"/>
                            <span class="italic">Kapanpun</span>
                        </li>
                    </ul>
                </div>
                <!-- Right Column -->
                <div class="px-1 md:px-4 font-montserrat">
                    <h3 class="text-xl md:text-2xl font-semibold mb-6">Cocok untuk <strong class="underline">muslim dewasa</strong>:</h3>
                    <div class="space-y-6">
                        <div class="flex items-center">
                            <div class="text-base md:text-2xl">
                                <p>Yang ingin <span class="font-bold">tadabbur Al-Qur'an sampai level bahasa Arabnya</span></p>
                            </div>
                            <img src="{{ asset('images/qac lite/1.png') }}" alt="QAC 1.0 Lite" class="h-24 md:h-48 ml-auto">
                        </div>
                        <div class="flex items-center">
                            <div class="text-base md:text-2xl">
                                <p>Yang ingin mengetahui <span class="font-bold">esensi pesan Al-Qur'an</span> untuknya</p>
                            </div>
                            <img src="{{ asset('images/qac lite/2.png') }}" alt="QAC 1.0 Lite" class="h-24 md:h-48 ml-auto">
                        </div>
                        <div class="flex items-center">
                            <div class="text-base md:text-2xl">
                                <p>Yang <span class="font-bold">mencari kebenaran</span>, ingin mengetahui <span class="font-bold">esensi hidup</span></p>
                            </div>
                            <img src="{{ asset('images/qac lite/3.png') }}" alt="QAC 1.0 Lite" class="h-24 md:h-48 ml-auto">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-8 font-montserrat">
            <div class="flex justify-center py-4">
                <h2 class="text-xl md:text-3xl font-bold mb-4 border-b-4 border-[#e9a621]">Apa itu QAC 1.0 Lite?</h2>
            </div>
            <p class="text-base md:text-xl mx-2"><span class="font-bold">QAC 1.0 Lite</span> adalah <span class="font-bold">pembelajaran komprehensif</span>, yang terdiri dari <span class="font-bold">2 unit</span> yang bisa
            dipelajari <span class="font-bold">secara berurutan tapi bisa bertahap</span> :
            </p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex justify-center">
                    <img src="{{ asset('images/qac lite/1a.png') }}" alt="QAC 1.0 a Lite" class="w-full h-auto mt-4 rounded-lg">
                </div>
                <div class="flex justify-center">
                    <img src="{{ asset('images/qac lite/1b.png') }}" alt="QAC 1.0 b Lite" class="w-full h-auto mt-4 rounded-lg">
                </div>
            </div>
        </div>
        

        <div class="py-8">
            <div class="flex justify-center py-4">
                <h2 class="text-lg md:text-3xl text-center font-bold mb-4 border-b-4 border-[#e9a621]">Fasilitas apa yang didapatkan?</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 font-montserrat">
                <div class="flex flex-col content-start px-2">
                    <div class="flex justify-center">
                        <h3 class="text-2xl md:text-3xl font-bold mb-4 p-2 bg-[#490d0d] text-white rounded-lg">QAC 1a</h3>
                    </div>
                    <ul class="space-y-3 text-sm md:text-base bg-[#ffdf79]">
                        <li class="p-4 text-center border-b border-black">
                        10 video materi pembelajaran, <span class="font-bold">bisa diakses selama 1 bulan dari waktu daftar</span>
                        </li>
                        <li class="p-4 text-center border-b border-black">
                        Materi : teori & latihan bentuk <span class="font-bold">pdf di download</span> di web
                        </li>
                        <li class="p-4 text-center border-b border-black">
                        <span class="font-bold">ONLINE LIVE ZOOM</span> untuk  Q & A pembelajaran <span class="font-bold">di setiap akhir pekan selama 4 kali/bulan</span>
                        </li>
                        <li class="p-4 text-center border-b border-black">
                        <span class="font-bold">Video Free Event QAC</span> : Contoh Ngobrolin Quran, Free Sharing, dl bisa diakses <span class="font-bold">selama 1 bulan dari waktu daftar</span>
                        </li>
                        <li class="p-4 text-center border-b border-black">
                        Masuk <span class="font-bold">grup Whatsapp QAC 1a</span>
                        </li>
                        <li class="p-4 text-center border-b border-black">
                        <span class="font-bold">Sertifikat belajar</span>
                        </li>
                    </ul>
                </div>
                <div class="flex flex-col content-start px-2">
                    <div class="flex justify-center">
                    <h3 class="text-2xl md:text-3xl font-bold mb-4 p-2 bg-[#490d0d] text-white rounded-lg">QAC 1b</h3>
                    </div>
                    <ul class="space-y-3 text-sm md:text-base bg-[#ffdf79]">
                        <li class="p-4 text-center border-b border-black">
                        10 video materi pembelajaran, <span class="font-bold">bisa diakses selama 1 bulan dari waktu daftar</span>
                        </li>
                        <li class="p-4 text-center border-b border-black">
                        Materi : teori & latihan bentuk <span class="font-bold">pdf di download</span> di web
                        </li>
                        <li class="p-4 text-center border-b border-black">
                        <span class="font-bold">ONLINE LIVE ZOOM</span> untuk  Q & A pembelajaran <span class="font-bold">di setiap akhir pekan selama 4 kali/bulan</span>
                        </li>
                        <li class="p-4 text-center border-b border-black">
                        <span class="font-bold">Video Free Event dan Program Alumni QAC (hampir 200 video)</span> : contoh tadabbur Al-Qur’an, Step tadabbur pemula, Travel to Allah, Invitation to Baitullah, Redefinition, Surah at Glance dll, bisa diakses <span class="font-bold">selama 1 bulan dari waktu daftar</span>
                        </li>
                        <li class="p-4 text-center border-b border-black">
                        <p>Masuk <span class="font-bold">grup Whatsapp QAC 1b dan *grup Whatsapp info alumni</span> (sekitar 1000 alumni)</p>
                        <p><span class="text-xs">*setelah menyelesaikan sampai QAC 1b</span></p>
                        </li>
                        <li class="p-4 text-center border-b border-black">
                        <span class="font-bold">Sertifikat belajar</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="py-8 font-montserrat">
            <div class="flex justify-center py-4">
                <h2 class="text-xl md:text-3xl font-bold mb-4 border-b-4 border-[#e9a621]">FAQ</h2>
            </div>
            <div class="max-w-4xl mx-auto px-4 text-base md:text-xl">
                <!-- FAQ Item 1 -->
                <div class="mb-6">
                    <h3 class="font-bold mb-2">Bagaimana kalau hanya ambil QAC 1a saja ?</h3>
                    <p>Tidak bisa, karena QAC 1a masih 50% dari keseluruhan materi QAC 1.0 Lite, sehingga untuk mendapatkan pemahaman utuh harus diselesaikan hingga QAC 1b.</p>
                </div>

                <!-- FAQ Item 2 -->
                <div class="mb-6">
                    <h3 class="font-bold mb-2">Bagaimana kalau saya alumni QAC 1.0 yang dulu, mau ikutan QAC 1.0 lite ? Berapa investasinya & caranya bagaimana ?</h3>
                    <p>Alumni QAC 1.0 dianggap sebagai reseat = cukup inventasi 50% dari QAC 1.0 lite, cara daftar seperti biasa, masuk ke web <a href="/" class="text-blue-600 hover:underline">qacjakarta.id</a></p>
                </div>

                <!-- FAQ Item 3 -->
                <div class="mb-6">
                    <h3 class="font-bold mb-2">Saya ingin ikut acara-acara alumni QAC 1.0 yang Live, bagaimana caranya ?</h3>
                    <p>Selesaikan sampai dengan QAC 1b</p>
                </div>

                <!-- FAQ Item 4 -->
                <div class="mb-6">
                    <h3 class="font-bold mb-2">Saya sudah dapat akses rekaman materi belajar QAC 1.0 Lite tetapi ingin bisa ikut yang Live QAC 1.0, bagaimana caranya ?</h3>
                    <p>Untuk mengikuti QAC 1.0 Live silakan daftar di Waiting List Kelas QAC 1.0 (<a href="{{ route('kelas.qac-1') }}" class="text-blue-600 hover:underline">Link daftar QAC 1.0</a>)</p>
                </div>

                <!-- FAQ Item 5 -->
                <div class="mb-6">
                    <h3 class="font-bold mb-2">Apakah ada kelas lanjutan setelah selesai QAC 1b ?</h3>
                    <p>Ada, yaitu QAC 2.0 silakan daftar di Waiting List Kelas QAC 2.0 (<a href="{{ route('kelas.qac-2') }}" class="text-blue-600 hover:underline">Link daftar QAC 2.0</a>)</p>
                </div>
            </div>
        </div>
        <section id="register" class="mx-auto text-center mt-12 mb-12">
            <h1 class="w-full my-2 text-xl md:text-3xl font-bold leading-tight text-center text-gray-900">
                @lang('Bergabung Bersama Para Pejuang')
            </h1>
            <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-64 my-0 py-0 rounded-t"></div>
            </div>
            <h3 class="my-4 text-base md:text-2xl leading-tight">
                @lang('Jadilah bagian dari ribuan alumni')
            </h3>
            @if($course)
            <div class="py-8">
                <x-register-button href="{{ route('kelas.register', ['course_id' => $course->id]) }}">
                    @lang('Daftar QAC 1.0 Lite')
                </x-register-button>
            </div>
            @endif
        </section>      
    </div>
</x-web-layout>