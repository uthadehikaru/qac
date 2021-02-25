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
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <x-panel>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ $batch->name }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Jadwal Kelas : {{ $batch->duration }}
                </p>
            </div>
            <div class="border-t border-gray-200 mb-2">
                <dl>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                        Tentang Course
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">
                        {{ $batch->course->description }}
                        </dd>
                    </div>
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">
                        Tentang Batch
                        </dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">
                        {{ $batch->description }}
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