<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} {{ $title??'' }}</title>
        
        <link rel="icon" href="{{ asset('qacnew.png') }}" type="image/png" sizes="16x16">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--bg-opacity:1;background-color:#fff;background-color:rgba(255,255,255,var(--bg-opacity))}.bg-gray-100{--bg-opacity:1;background-color:#f7fafc;background-color:rgba(247,250,252,var(--bg-opacity))}.border-gray-200{--border-opacity:1;border-color:#edf2f7;border-color:rgba(237,242,247,var(--border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{box-shadow:0 1px 3px 0 rgba(0,0,0,.1),0 1px 2px 0 rgba(0,0,0,.06)}.text-center{text-align:center}.text-gray-200{--text-opacity:1;color:#edf2f7;color:rgba(237,242,247,var(--text-opacity))}.text-gray-300{--text-opacity:1;color:#e2e8f0;color:rgba(226,232,240,var(--text-opacity))}.text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}.text-gray-500{--text-opacity:1;color:#a0aec0;color:rgba(160,174,192,var(--text-opacity))}.text-gray-600{--text-opacity:1;color:#718096;color:rgba(113,128,150,var(--text-opacity))}.text-gray-700{--text-opacity:1;color:#4a5568;color:rgba(74,85,104,var(--text-opacity))}.text-gray-900{--text-opacity:1;color:#1a202c;color:rgba(26,32,44,var(--text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--bg-opacity:1;background-color:#2d3748;background-color:rgba(45,55,72,var(--bg-opacity))}.dark\:bg-gray-900{--bg-opacity:1;background-color:#1a202c;background-color:rgba(26,32,44,var(--bg-opacity))}.dark\:border-gray-700{--border-opacity:1;border-color:#4a5568;border-color:rgba(74,85,104,var(--border-opacity))}.dark\:text-white{--text-opacity:1;color:#fff;color:rgba(255,255,255,var(--text-opacity))}.dark\:text-gray-400{--text-opacity:1;color:#cbd5e0;color:rgba(203,213,224,var(--text-opacity))}}
        </style>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            'montserrat': ['Montserrat', 'sans-serif'],
                            'comfortaa': ['Comfortaa', 'sans-serif'],
                        }
                    }
                }
            }
        </script>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/web.css') }}">
        {{ $styles ?? '' }}
    </head>
    <body class="leading-normal tracking-normal font-comfortaa">
        <!--Nav-->
        <nav class="fixed w-full z-30 top-0 border-b-4 bg-white border-red-800">
        <div class="w-full container mx-auto flex flex-wrap items-center justify-between mt-0 py-2">
            <div class="pl-2 md:pl-4 flex items-center">
                <a class="no-underline hover:no-underline font-bold text-2xl lg:text-4xl" href="{{ url('') }}">
                    <img class="h-8 md:h-14 inline" src="{{ asset('qacnew.png') }}" />
                </a>
            </div>
            <ul class="list-reset flex justify-center flex-1 items-center">
                <li class="mr-3 dropdown relative">
                    <button class="inline-block flex items-center text-xs md:text-base py-2 md:py-2 md:px-4 {{ request()->is('kelas*') ? 'text-[#7b0c00]' : 'text-black' }} no-underline text-center hover:text-red-800">
                        Kelas
                        <svg class="h-4 w-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div class="dropdown-menu absolute hidden bg-white font-bold shadow-lg text-xs md:text-base border-2 border-[#ffdf79]">
                        @if($qac_lite_1a || $qac_lite_1b)
                        <a href="{{ route('kelas.qac-1-lite') }}" class="block mx-4 my-2 px-4 py-2 text-black rounded-md {{ request()->is('kelas/qac-1-lite') ? 'bg-[#ffdf79]' : 'hover:bg-[#ffdf79]' }} whitespace-nowrap">QAC 1.0 Lite (Self Paced)</a>
                        <a href="{{ route('member.ecourses.lessons', 'qac-10-lite-1a') }}" class="block mx-4 my-2 px-4 py-2 text-black rounded-md {{ request()->is('member/ecourses/lessons/qac-10-lite-1a') ? 'bg-[#ffdf79]' : 'hover:bg-[#ffdf79]' }} whitespace-nowrap">Kelas QAC 1a</a>
                        <a href="{{ $qac_lite_1b ? route('member.ecourses.lessons', 'qac-10-lite-1b') : '#' }}" class="block mx-4 my-2 px-4 py-2 text-black rounded-md {{ request()->is('member/ecourses/lessons/qac-10-lite-1b') ? 'bg-[#ffdf79]' : 'hover:bg-[#ffdf79]' }} whitespace-nowrap">Kelas QAC 1b</a>
                        @else
                        <a href="{{ route('kelas.qac-1-lite') }}" class="block mx-4 my-2 px-4 py-2 text-black rounded-md {{ request()->is('kelas/qac-1-lite') ? 'bg-[#ffdf79]' : 'hover:bg-[#ffdf79]' }} whitespace-nowrap">QAC 1.0 Lite (Self Paced)</a>
                        @endif
                        <a href="{{ route('kelas.qac-1') }}" class="block mx-4 my-2 px-4 py-2 text-black rounded-md {{ request()->is('kelas/qac-1') ? 'bg-[#ffdf79]' : 'hover:bg-[#ffdf79]' }} whitespace-nowrap">QAC 1.0 (Basic Grammar)</a>
                        <a href="{{ route('kelas.qac-2') }}" class="block mx-4 my-2 px-4 py-2 text-black rounded-md {{ request()->is('kelas/qac-2') ? 'bg-[#ffdf79]' : 'hover:bg-[#ffdf79]' }} whitespace-nowrap">QAC 2.0 (Basic Sharf)</a>
                        <a href="{{ route('kelas.qac-3') }}" class="block mx-4 my-2 px-4 py-2 text-black rounded-md {{ request()->is('kelas/qac-3') ? 'bg-[#ffdf79]' : 'hover:bg-[#ffdf79]' }} whitespace-nowrap">QAC 3.0 (Advance Grammar)</a>
                    </div>
                </li>
                <li class="mr-3">
                    <a href="{{ route('ecourses.index') }}" class="inline-block py-2 text-xs md:text-base md:py-2 md:px-4 {{ request()->is('ecourses*') ? 'text-[#7b0c00]' : 'text-black' }} no-underline text-center hover:text-red-800">Program Alumni</a>
                </li>
                <li class="">
                    <a href="{{ route('event.list') }}" class="inline-block py-2 text-xs md:text-base md:py-2 md:px-4 {{ request()->is('event*') ? 'text-[#7b0c00]' : 'text-black' }} no-underline text-center hover:text-red-800">Event</a>
                </li>
            </ul>
            <div class="block pr-4">
            <button id="nav-toggle" class="flex items-center p-1 text-pink-800 hover:text-gray-900 focus:outline-none focus:shadow-outline transform transition hover:scale-105 duration-300 ease-in-out">
                <svg class="fill-current h-6 w-6" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <title>Menu</title>
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
                </svg>
            </button>
            </div>
            <div class="w-full flex-grow hidden mt-2 text-black p-4 z-20" id="nav-content">
            <ul class="list-reset justify-end flex-1 text-xs md:text-base items-center">
                <li class="mr-3 text-right">
                <a class="inline-block text-black no-underline hover:text-red-800 hover:text-underline py-2 px-4" href="{{ route('testimonials') }}">Testimoni</a>
                </li>
                <li class="mr-3 text-right">
                <a class="inline-block text-black no-underline hover:text-red-800 hover:text-underline py-2 px-4" href="{{ route('faq') }}">FAQ</a>
                </li>
                <li class="mr-3 text-right">
                <a class="inline-block text-black no-underline hover:text-red-800 hover:text-underline py-2 px-4" href="{{ route('donasi') }}">Donasi</a>
                </li>
                <li class="mr-3 text-right">
                    @guest    
                    <a class="inline-block text-black no-underline hover:text-red-800 hover:text-underline py-2 px-4" href="javascript:void(0)" onclick="toggleModal()">Daftar/Masuk</a>
                    @endguest
                    @auth
                    @if(auth()->user()->role == 'member')
                    <a class="inline-block text-black no-underline hover:text-red-800 hover:text-underline py-2 px-4" href="{{ route('member.profile') }}">Profil</a>
                    @else
                    <a class="inline-block text-black no-underline hover:text-red-800 hover:text-underline py-2 px-4" href="{{ route('admin.dashboard') }}">Admin</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="inline-block text-black no-underline hover:text-red-800 hover:text-underline py-2 px-4">
                            Keluar
                        </button>
                    </form>
                    @endauth
                </li>
            </ul>
            </div>
        </div>
        <hr class="border-b border-gray-100 opacity-25 my-0 py-0" />
        </nav>
        {{ $slot }}
        
        <div class="hidden z-10 overflow-y-auto top-0 w-full left-0" id="modal">
            <div class="flex items-center justify-center min-height-100vh pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-900 opacity-75">
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">​</span>
                <div class="inline-block align-center bg-white rounded-lg text-left overflow-hidden shadow-xl 
                transform transition-all mt-20 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="text-black px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <h1 class="text-2xl mb-2 text-center">Panduan Login/masuk Akun QAC</h1>

                <p class="mb-2">Assalamu'alaikum Warahmatullahi Wabarakatuh..</p>

                <p class="mb-2">Untuk bisa <a href="{{ route('login') }}" class="underline font-bold pointer">masuk</a> ke dalam Website qacjakarta.id, Anda harus sudah daftar akun atau daftar kelas
                QAC 1.0 Lite</p>

                <p class="mb-2">Silahkan isi yang dimasukkan saat pendaftaran (yang terdaftar) :</p>
                <ul class="list-disc ml-4 mb-2">
                    <li><span class="font-bold">Kolom Email</span> dengan <span class="font-bold">EMAIL ANDA</span></li>
                    <li><span class="font-bold">Kolom Pasword</span> dengan <span class="font-bold">NOMOR HP ANDA ATAU SESUAI YANG ANDA ISI</span></li>
                </ul>

                <p class="mb-2">Bila password lupa, maka klik "Lupa kata sandi" atau anda bisa menggunakan "OTP" untuk login</p>

                <p class="mb-2">Jika mengalami kesulitan, bisa DM instagram <a href="https://www.instagram.com/qacjakarta/" target="_blank">@qacjakarta</a></p>
                </div>
                <div class="bg-white px-4 py-3 text-right">
                    <button type="button" id="close-modal" class="border-2 border-red-800 text-red-800 px-4 rounded-full mr-2" onclick="toggleModal()">Tutup</button>
                    <x-qac-button href="{{ route('login') }}" class="text-center">Daftar/Masuk</x-qac-button>
                </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
        <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        </script>
        {{ $scripts ?? '' }}
        
        <script>
        /*Toggle dropdown list*/
        /*https://gist.github.com/slavapas/593e8e50cf4cc16ac972afcbad4f70c8*/

        var navMenuDiv = document.getElementById("nav-content");
        var navMenu = document.getElementById("nav-toggle");

        document.onclick = check;
        function check(e) {
            var target = (e && e.target) || (event && event.srcElement);

            //Nav Menu
            if (!checkParent(target, navMenuDiv)) {
            // click NOT on the menu
            if (checkParent(target, navMenu)) {
                // click on the link
                if (navMenuDiv.classList.contains("hidden")) {
                navMenuDiv.classList.remove("hidden");
                } else {
                navMenuDiv.classList.add("hidden");
                }
            } else {
                // click both outside link and outside menu, hide menu
                navMenuDiv.classList.add("hidden");
            }
            }
        }
        function checkParent(t, elm) {
            while (t.parentNode) {
            if (t == elm) {
                return true;
            }
            t = t.parentNode;
            }
            return false;
        }
        function toggleModal() { 
            document.getElementById('modal').classList.toggle('hidden')
            $('#nav-content').addClass('hidden')
        }

        
        jQuery(document).ready(function($){
            $('#modal').click(function(){
                $(this).addClass('hidden')
            })
            $('#close-modal').click(function(){
                $('#modal').addClass('hidden')
            })
            
            // Dropdown functionality
            $('.dropdown').hover(
                function() {
                    $(this).find('.dropdown-menu').show();
                },
                function() {
                    $(this).find('.dropdown-menu').hide();
                }
            );
            
            // Also handle click events for mobile
            $('.dropdown button').click(function(e) {
                e.preventDefault();
                var dropdownMenu = $(this).siblings('.dropdown-menu');
                $('.dropdown-menu').not(dropdownMenu).hide();
                dropdownMenu.toggle();
            });
            
            // Close dropdown when clicking outside
            $(document).click(function(e) {
                if (!$(e.target).closest('.dropdown').length) {
                    $('.dropdown-menu').hide();
                }
            });
        });
        </script>
        @if(config('app.analytic'))
        <x-analytic/>
        @endif
    </body>
</html>
