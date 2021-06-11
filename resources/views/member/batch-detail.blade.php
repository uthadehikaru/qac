<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __('Course Detail') }}
        </h2>
    </x-slot>

    @if(session('error'))
        <x-alert type="warning">{{ session('error') }}</x-alert>
    @endif

    @if(session('success'))
        <x-alert type="success">{!! session('success') !!}</x-alert>
    @endif

    <x-panel>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ $batch->full_name }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ $batch->duration }}
                </p>
            </div>
            <div class="border-t border-gray-200 mb-2">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                        Deskripsi
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">
                        {{ $batch->course->description }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                        Jadwal
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">
                        {{ $batch->description }}
                        </dd>
                    </div>
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Lampiran
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">
                    <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                        @if($batch->file)
                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <!-- Heroicon name: solid/paper-clip -->
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-2 flex-1 w-0 truncate">
                            {{ $batch->file->name }}
                            </span>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="{{ $batch->file->fileUrl('filename') }}" 
                            target="_blank" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Unduh
                            </a>
                        </div>
                        </li>
                        @endif
                    </ul>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                        &nbsp;
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">
                        <form method="POST" action="{{ route('member.batch.register', $batch->id) }}">
                        @csrf
                        @if($batch->sessionList())
                        <select id="session" class="text-black" name="session">
                            @foreach($batch->sessionList() as $session)
                            <option value="{{ $session }}">{{ $session }}</option>
                            @endforeach
                        </select>
                        @endif
                        <x-button class="bg-blue-500">Daftar</x-button>
                        </form>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </x-panel>
</x-app-layout>