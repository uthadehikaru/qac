<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(!Auth::user()->member->isCompleted())
        <x-alert type="warning">Mohon lengkapi data pribadi anda, <a href="{{ route('member.profile') }}" class="text-blue-500 pointer">klik disini</a></x-alert>
    @endif

    @if(session('message'))
        <x-alert type="info">{{ session('message') }}</x-alert>
    @endif
    
    @if(session('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
    @endif

    @if($member->batches->count()>0)
    <div class="m-6">
        <p class="block text-lg font-bold text-gray-700">Kelas yang diikuti</p>
        <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

            <table class="table-auto w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kelas
                        </th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jadwal
                        </th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white text-xs divide-y divide-gray-200">
                    @foreach($member->batches as $batch)
                    <tr>
                        <td class="px-2 py-4 text-sm text-gray-500">

                            <div class="flex justify-start space-x-1">
                                <a href="{{ route('member.batches.detail', $batch->pivot->id) }}" class="border-2 border-indigo-200 rounded-md p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-indigo-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                @if($batch->file)
                                <a href="{{ $batch->file->fileUrl('filename') }}" target="_blank" class="border-2 border-indigo-200 rounded-md p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-indigo-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </a>
                                @endif
                            </div>
                        </td>
                        <td class="px-2 py-4">
                            {{ $batch->full_name }} {{ $batch->session }}
                        </td>
                        <td class="px-2 py-4">
                            {{ $batch->duration }}
                        </td>
                        <td class="px-2 py-4">
                            @lang('batch.status_'.$batch->pivot->status)
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <div class="m-6">
        <p class="block text-lg font-bold text-gray-700">Kelas yang tersedia</p>
        <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

            <table class="table-auto w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Level
                        </th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kelas
                        </th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white text-xs divide-y divide-gray-200">
                    @foreach($courses as $course)
                    <tr>
                        <td class="px-2 py-4">
                            {{ $course->name }}
                        </td>
                        <td class="px-2 py-4">
                            @if($course->lastBatch() && $course->lastBatch()->isOpen)
                                {{ $course->lastBatch()->full_name }}
                            @else
                                Kelas belum tersedia
                            @endif
                        </td>
                        <td class="px-2 py-4">
                            @if($course->lastBatch() && $course->lastBatch()->isOpen)
                            <a href="{{ route('member.batch.detail', $course->lastBatch()->id) }}" class="text-green-500 pointer">Daftarkan kelas</a>
                            @elseif($course->members()->where('member_id',$member->id)->exists())
                            <a href="{{ route('member.waitinglist', $course->id) }}" class="text-red-500 pointer">Batalkan waiting list</a>
                            @else
                            <a href="{{ route('member.waitinglist', $course->id) }}" class="text-blue-500 pointer">Daftarkan waiting list</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="m-6">
        <p class="block text-lg font-bold text-gray-700">Event QAC Mendatang</p>
        <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>

                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Event
                        </th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Jadwal
                        </th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white text-xs divide-y divide-gray-200">
                    @forelse($incomingEvents as $event)
                    <tr>

                        <td class="px-2 py-4">
                            {{ $event->title }}
                        </td>
                        <td class="px-2 py-4">
                            {{ $event->event_at->format('d F Y H:i') }}
                        </td>
                        <td class="px-2 py-4">
                            {{ $event->is_public?'Umum':'Khusus Anggota QAC' }}
                        </td>
                        <td class="px-2 py-4 text-sm text-gray-500">
                            <div class="flex justify-start space-x-1">
                                <a href="{{ route('event.detail', $event->slug) }}" class="border-2 border-indigo-200 rounded-md p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-indigo-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-2 py-4">Belum ada event</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>