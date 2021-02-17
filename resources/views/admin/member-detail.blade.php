<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __('Member') }} - {{ $member->name }}
        </h2>
        <div class="float-right">
        {{ $member->user->email }} | {{ $member->phone }}
        </div>
    </x-slot>
</x-app-layout>