<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __($order?'Edit':'Add') }} {{ __('Order') }}
        </h2>
        <div class="float-right">
            <x-link-button href="{{ route('admin.orders.index') }}" class=" ml-3" type="warning">Back</x-button>
        </div>
    </x-slot>

    <x-panel>
    
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form id="form" method="post" 
        action="{{ route('admin.orders.store') }}">
            @csrf
            <div class="px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <h1 class="text-xl font-bold mt-2">Add All Paid Members</h1>
                <p class="italic">anggota yang telah lunas pembayaran di seluruh course akan mendapat langganan aktif gratis</p>
                <div class="-mx-3 md:flex mb-6 mt-2">
                    <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-start_date">
                            Start Date
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-start_date" name="start_date" type="date" placeholder="member start_date" value="{{ old('start_date', $order?$order->start_date:'') }}" required>
                    </div>
                    <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-end_date">
                            End Date
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-end_date" name="end_date" type="date" placeholder="member end_date" value="{{ old('end_date', $order?$order->end_date:'') }}">
                    </div>
                </div>
                <button type="submit" class="p-4 border bg-blue-500 rounded text-white">Save</button>
            </div>
        </form>
    </x-panel>
</x-app-layout>