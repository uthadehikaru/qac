<x-web-layout>
<section id="faq" class="bg-white pt-24 text-gray-700">
    <div class="container px-5 py-6 mx-auto">
        <div class="text-center mb-20">
            <h1 class="text-4xl font-medium text-center title-font text-gray-900 mb-4">
            @yield('code')
            </h1>
            <p class="text-base leading-relaxed xl:w-2/4 lg:w-3/4 mx-auto mb-4">
            @yield('message')
            </p>
            <a href="{{ route('home') }}" class="text-blue-500">kembali ke halaman utama</a>
        </div>
    </div>
</section>
</x-web-layout>