<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(!$member->isCompleted())
        <x-alert type="warning" title="Perhatian">Mohon lengkapi data pribadi anda, <a href="{{ route('member.profile') }}" class="text-blue-500 pointer">klik disini</a></x-alert>
    @endif
    
    @if(!$member->user->email_verified_at)
        <x-alert type="warning" title="Perhatian">Mohon konfirmasi alamat email anda sekarang, <a href="{{ route('verification.notice') }}" class="text-blue-500 pointer">klik disini</a></x-alert>
    @endif

    @if(session('message'))
        <x-alert type="info">{{ session('message') }}</x-alert>
    @endif
    
    @if(session('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
    @endif

    <a href="{{ route('member.profile') }}"><x-alert type="success" title="Alamat Pengiriman">{{ $member->full_name }} ({{ $member->phone }}) - {{ $member->address_detail }}. <span class="underline text-blue-500"> (perbaharui alamat)</span></x-alert></a>

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
                                <a href="{{ route('member.batches.detail', $batch->pivot->id) }}" class="border-2 bg-indigo-500 text-white rounded-md p-1">
                                    Detail
                                </a>
                                @if($batch->file)
                                <a href="{{ $batch->file->fileUrl('filename') }}" target="_blank" class="border-2 bg-indigo-500 text-white rounded-md p-1">
                                    Sertifikat
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
                            Aksi
                        </th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Level
                        </th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kelas
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white text-xs divide-y divide-gray-200">
                    @foreach($courses as $course)
                    <tr>
                        <td class="px-2 py-4">
                            @if($course->lastBatch() && $course->lastBatch()->isOpen)
                            <a href="{{ route('member.batch.detail', $course->lastBatch()->id) }}" class="bg-green-500 text-white rounded-md p-1">
                                {{ $member->isReseat($course->lastBatch()) ? 'Reseat' : 'Daftar kelas' }}
                            </a>
                            @elseif($course->members()->where('member_id',$member->id)->exists())
                            <a href="{{ route('member.waitinglist', $course->id) }}" class="bg-red-500 text-white rounded-md p-1">Batalkan waiting list</a>
                            @else
                            <a href="{{ route('member.waitinglist', $course->id) }}" class="bg-blue-500 text-white rounded-md p-1">Daftar Waiting List</a>
                            @endif
                        </td>
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
                            Aksi
                        </th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Event
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
                    @forelse($incomingEvents as $event)
                    <tr>

                        <td class="px-2 py-4 text-sm text-gray-500">
                            <div class="flex justify-start space-x-1">
                                <a target="_blank" href="{{ route('event.detail', $event->slug) }}" class="pointer border-2 border-indigo-200 rounded-md p-1">
                                    Detail
                                </a>
                            </div>
                        </td>
                        <td class="px-2 py-4">
                            <a target="_blank" href="{{ route('event.detail', $event->slug) }}" class="pointer text-blue-500">{{ $event->title }}</a>
                        </td>
                        <td class="px-2 py-4">
                            {{ $event->event_at->format('d F Y H:i') }}
                        </td>
                        <td class="px-2 py-4">
                            {{ $event->is_public?'Umum':'Khusus Anggota QAC' }}
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