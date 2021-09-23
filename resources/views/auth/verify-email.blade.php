<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Untuk memastikan informasi dan notifikasi kami selalu diterima anda, mohon untuk konfirmasi alamat email anda dengan mengklik tombol dibawah.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Tautan untuk verifikasi email telah dikirim ke alamat email anda. mohon cek kotak masuk anda sekarang.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button>
                        {{ __('Kirim Email Verifikasi') }}
                    </x-button>
                </div>
            </form>

            <a type="submit" href="{{ route('member.dashboard') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                    {{ __('Kembali') }}
</a>
        </div>
    </x-auth-card>
</x-guest-layout>
