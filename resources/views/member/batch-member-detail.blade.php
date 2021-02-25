<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __('Course Detail') }}
        </h2>
    </x-slot>

    <x-panel>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ $batchMember->batch->name }} {{ $batchMember->session }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ $batchMember->approved_at?'Approved at '.$batchMember->approved_at->format('d-M-Y H:i'):'Not Approved' }}
                </p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    About Course
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $batchMember->batch->course->description }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Description
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                    {{ $batchMember->batch->description }}
                    </dd>
                </div>
                </dl>
            </div>
        </div>
    </x-panel>
</x-app-layout>