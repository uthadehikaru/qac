<x-member-layout>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        @if(session('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
        @endif

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form id="password" method="post" action="{{ route('member.password.update') }}">
        @csrf
        <div class="px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-old-password">
                        Password Saat Ini
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-old-password" name="old_password" type="password" placeholder="Password saat ini" required>
                </div>
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-new-password">
                        Password Baru
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-new-password" name="new_password" type="password" placeholder="Password baru" required>
                </div>
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-re-password">
                        Ulangi Password Baru
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-re-password" name="re_password" type="password" placeholder="Ulangi password baru" required>
                </div>
                <x-button>Ubah Password</x-button>
            </div>
        </div>
        </form>
</x-member-layout>