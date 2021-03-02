<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(Auth::user()->is_member && !Auth::user()->member->isCompleted())
        <x-alert type="warning">Mohon lengkapi data pribadi anda, <a href="{{ route('member.profile') }}" class="text-blue-500 pointer">klik disini</a></x-alert>
    @endif

    <!-- This is an example component -->
    <div id="wrapper" class="w-full p-4 mx-auto">
        <div class="sm:grid sm:h-32 sm:grid-flow-row sm:gap-4 sm:grid-cols-3">
            <div id="jh-stats" class="flex flex-col justify-center px-4 py-4 bg-white border border-gray-300 rounded">
                <div>
                    <p class="text-3xl font-semibold text-center text-gray-800">{{ $all_members }}</p>
                    <p class="text-lg text-center text-gray-500">All Members</p>
                    <p class="text-center"><a href="{{ route('admin.members.index') }}" class="text-sm text-blue-500 pointer">details</a></p>
                </div>
            </div>
            <div id="jh-stats" class="flex flex-col justify-center px-4 py-4 bg-white border border-gray-300 rounded">
                <div>
                    <p class="text-3xl font-semibold text-center text-gray-800">{{ $unverified_members }}</p>
                    <p class="text-lg text-center text-gray-500">Unverified Members</p>
                    <p class="text-center"><a href="{{ route('admin.members.index', ['unverified'=>true]) }}" class="text-sm text-blue-500 pointer">details</a></p>
                </div>
            </div>
            <div id="jh-stats" class="flex flex-col justify-center px-4 py-4 bg-white border border-gray-300 rounded">
                <div>
                    <p class="text-3xl font-semibold text-center text-gray-800">{{ $unapproved_members }}</p>
                    <p class="text-lg text-center text-gray-500">Unapproved Members</p>
                    <p class="text-center"><a href="#" class="text-sm text-blue-500 pointer">details</a></p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>