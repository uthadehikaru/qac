<x-web-layout>
    <x-slot name="title"> - Online Course {{ $ecourse->title }}</x-slot>
    
    <section class="mt-20 bg-white text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-24 mx-auto">
            <div class="lg:w-4/5 mx-auto flex flex-wrap">
                <div class="lg:w-1/2 w-full p-2">
                    <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ $ecourse->title }}</h1>
                    <img alt="{{ $ecourse->title }}" class="w-full lg:h-auto h-64 object-contain object-center rounded" src="{{ $ecourse->imageUrl('thumbnail') }}" />
                    <p class="leading-relaxed mt-2">{!! nl2br($ecourse->description) !!}</p>
                </div>
                <div class="lg:w-1/2 w-full p-2">
                    @if(session('error'))
                    <x-alert type="warning">{{ session('error') }}</x-alert>
                    @endif
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="flex flex-col text-center w-full mb-12">
                        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Masuk</h1>
                        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">gunakan email dan password akun anda</p>
                    </div>
                    <div class="w-full mx-auto">
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="email_or_phone" class="leading-7 text-sm text-gray-600">Email</label>
                                    <input type="text" id="email_or_phone" name="email_or_phone" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="password" class="leading-7 text-sm text-gray-600">Password</label>
                                    <input type="password" id="password" name="password" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                            <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Masuk</button>
                            </div>
                            
                        </div>
                    </div>
                    </form>
                    <hr class="my-2" />
                    <div class="flex flex-col text-center w-full mb-12">
                        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">atau Daftar</h1>
                        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Daftarkan data anda terlebih dahulu</p>
                    </div>
                    <div class="w-full mx-auto">
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="name" class="leading-7 text-sm text-gray-600">Name</label>
                                    <input type="text" id="name" name="name" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="email" class="leading-7 text-sm text-gray-600">Email</label>
                                    <input type="email" id="email" name="email" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="phone" class="leading-7 text-sm text-gray-600">No Telp</label>
                                    <input type="text" id="phone" name="phone" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-1/2">
                                <div class="relative">
                                    <label for="password" class="leading-7 text-sm text-gray-600">Password</label>
                                    <input type="password" id="password" name="password" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                </div>
                            </div>
                            <div class="p-2 w-full">
                            <button class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Daftar</button>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-web-layout>