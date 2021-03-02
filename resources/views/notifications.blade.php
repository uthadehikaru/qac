<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ count($notifications) }} {{ __('Notifications') }}
        </h2>
        @if(Auth::user()->unreadNotifications()->count())
        <div class="float-right">
            <x-link-button  href="{{ route('notifications.read') }}" class=" ml-3">Mark As Read</x-link-button>
        </div>
        @endif
    </x-slot>

    <x-panel>
        @foreach($notifications as $notification)
        <x-alert type="{{ $notification->read_at?'default':'info' }}" title="notice">
            @if(isset($notification->data['link']))
            <a href="{{ $notification->data['link'] }}" class="pointer">
            {{ $notification->data['message'] }}
            </a>
            @else
            {{ $notification->data['message'] }}
            @endif
        </x-alert>
        @endforeach
        {{ $notifications->links() }}
    </x-panel>

</x-app-layout>