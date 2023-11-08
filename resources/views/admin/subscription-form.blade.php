<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __($subscription?'Edit':'New') }} {{ __('Subscriber') }}
        </h2>
        <div class="float-right">
            <x-link-button  href="javascript:void(0)" onclick="document.getElementById('form').submit();" id="save" class=" ml-3">Simpan</x-button>
        </div>
    </x-slot>

    <x-panel>
    
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form id="form" method="post" 
        @if($subscription)
        action="{{ route('admin.ecourses.subscriptions.update', [$ecourse->id, $subscription->id]) }}"
        @else
        action="{{ route('admin.ecourses.subscriptions.store', $ecourse->id) }}"
        @endif
        enctype="multipart/form-data">
            @csrf

            @if($subscription)
                <input name="_method" type="hidden" value="PUT">
            @endif
            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-2/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-member_id">
                            Member
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-member_id" name="member_id">
                            <option value="">-- Pilih Member --</option>
                            @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ $subscription && $subscription->member_id==$member->id?'selected':'' }}>{{ $member->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-start_date">
                            Start Date
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-start_date" name="start_date" type="date" placeholder="member start_date" value="{{ old('start_date', $subscription?$subscription->start_date:'') }}">
                    </div>
                    <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-end_date">
                            End Date
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-end_date" name="end_date" type="date" placeholder="member end_date" value="{{ old('end_date', $subscription?$subscription->end_date:'') }}">
                    </div>
                </div>
            </div>
        </form>
    </x-panel>
</x-app-layout>