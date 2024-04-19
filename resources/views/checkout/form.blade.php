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
                    <form method="POST" action="{{ route('checkout', $ecourse->slug) }}">
                    @csrf
                    <div class="flex flex-col text-center w-full mb-12">
                        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Konfirmasi Berlangganan</h1>
                        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">langganan anda akan aktif setelah pembayaran dikonfirmasi</p>
                    </div>
                    <div class="w-full mx-auto">
                        <div class="flex flex-wrap -m-2">
                            <div class="p-2 w-full">
                            <div>
  <label for="months" class="block text-sm font-medium leading-6 text-gray-900">Lama Berlangganan (min. 1 bulan)</label>
  <div class="relative mt-2 rounded-md shadow-sm">
    <input type="number" name="months" id="months" class="block w-full rounded-md border-0 py-1.5 pl-2 pr-20 text-gray-900 
    ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 
    sm:text-sm sm:leading-6" placeholder="jumlah bulan" required>
    <div class="absolute inset-y-0 right-2 flex items-center">
      bulan
    </div>
  </div>
</div>
                            </div>
                            <div class="p-2 w-full">
                            <button type="submit" class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Daftar</button>
                            </div>
                            
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

</x-web-layout>