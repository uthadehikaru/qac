<x-app-layout>

    <section class="bg-white text-gray-600 body-font overflow-hidden">
        <div class="container px-5 py-24 mx-auto">
            <div class="lg:w-4/5 mx-auto flex flex-wrap">
                <div class="lg:w-1/2 w-full p-2">
                    <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">Subscribe Now!</h1>
                    <p class="leading-relaxed mt-2">Anda berhak mengakses Seluruh Online Course kami dengan berlangganan
                        hanya <span class="font-bold">@money(\App\Models\System::value('subscription_fee'))/bulan</span>
                    </p>
                    <p class="leading-relaxed mt-2"><a href="{{ route('ecourses.index') }}"
                            class="text-blue-500 font-bold">Lihat Daftar Online Course</a></p>
                </div>
                <div class="lg:w-1/2 w-full p-2">
                    @if(session('error'))
                        <x-alert type="warning">{{ session('error') }}</x-alert>
                    @endif
                    <x-auth-validation-errors class="mb-4" :errors="$errors" />
                    @if($order)
                        <div class="flex flex-col text-center w-full mb-12">
                                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Anda telah mengajukan langganan pada {{ $order->created_at->format('d M Y') }}</h1>
                                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">
                                    Hubungi <a href="https://wa.me/{{ \App\Models\System::value('whatsapp_ecourse') }}?text={{ urlencode('Halo QAC, saya ingin konfirmasi pesanan.') }}" 
                                    class="underline font-bold px-2" target="_blank"
                                    >whatsapp admin QAC</a> untuk informasi tata cara pembayaran dan pengiriman bukti transfer
                                </p>
                            </div>
                    @else
                        <form method="POST" action="{{ route('checkout') }}">
                            @csrf
                            <div class="flex flex-col text-center w-full mb-12">
                                <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Konfirmasi
                                    Berlangganan</h1>
                                <p class="lg:w-2/3 mx-auto leading-relaxed text-base">langganan anda akan aktif setelah
                                    pembayaran dikonfirmasi</p>
                            </div>
                            <div class="w-full mx-auto">
                                <div class="flex flex-wrap -m-2">
                                    <div class="p-2 w-full">
                                        <div>
                                            <label for="months"
                                                class="block text-sm font-medium leading-6 text-gray-900">Lama
                                                Berlangganan (min. 1 bulan)</label>
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
                                        <button type="submit"
                                            class="flex mx-auto text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">Daftar</button>
                                    </div>

                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
