<x-guest-layout>
    <x-slot name="title">
        - Nomor Telepon
    </x-slot>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <p class="mb-4 text-sm text-gray-600">
            {{ __('Mohon isi nomor telepon/WhatsApp Anda untuk melanjutkan.') }}
        </p>

        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('phone.complete.store') }}">
            @csrf

            <div>
                <x-label for="phone" :value="__('Phone')" />

                <x-input id="phone" class="block mt-1 w-full" placeholder="6281234567890" type="text" name="phone" :value="old('phone')" required autofocus />
            </div>

            <p class="mt-2 text-sm text-red-500">*pastikan nomor whatsapp aktif</p>

            <div class="flex items-center justify-end mt-4">
                <x-button>
                    {{ __('Simpan') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
