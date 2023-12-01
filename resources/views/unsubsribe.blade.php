<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600">
            {{ __('Notifikasi email anda telah dimatikan. Anda tidak akan menerima notifikasi email terkait acara-acara kami') }}
        </div>

        <div class="mb-4 font-medium text-sm text-green-600">
            {{ __('Jika anda ingin mendapatkan kembali notifikasi acara dari kami, silahkan mengaktifkan dari menu profil anda. Sampai Jumpa Kembali') }}
        </div>
    </x-auth-card>
</x-guest-layout>
