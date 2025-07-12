<x-member-layout>

    @if(session('message'))
        <x-alert type="info">{{ session('message') }}</x-alert>
    @endif
    
    @if(session('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
    @endif

    <div class="m-6" id="courses">
        <p class="block text-lg font-bold text-gray-700">Kelas yang tersedia</p>
        <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg mt-4">

            <table class="table-auto w-full divide-y divide-gray-200">
                <thead class="bg-[#ffdf79]">
                    <tr>
                        <th class="px-2 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">
                            Aksi
                        </th>
                        <th class="px-2 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">
                            Level
                        </th>
                        <th class="px-2 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">
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

    @if($member->batches->count()>0)
    <div class="m-6">
        <p class="block text-lg font-bold text-gray-700">Kelas yang diikuti</p>
        <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg mt-4">

            <table class="table-auto w-full divide-y divide-gray-200">
                <thead class="bg-[#ffdf79]">
                    <tr>
                        <th class="px-2 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">
                            Aksi
                        </th>
                        <th class="px-2 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">
                            Kelas
                        </th>
                        <th class="px-2 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">
                            Jadwal
                        </th>
                        <th class="px-2 py-3 text-center text-xs font-medium text-black uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white text-xs divide-y divide-gray-200">
                    @foreach($member->batches as $batch)
                    <tr>
                        <td class="px-2 py-4 text-sm text-gray-500">

                            <div class="flex flex-col md:flex-row justify-start space-x-1">
                                <a href="{{ route('member.batches.detail', $batch->pivot->id) }}" class="border-2 bg-blue-500 text-white rounded-md p-1 text-xs md:text-base">
                                    Detail
                                </a>
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
                            
                            @if($batch->file)
                            <a href="{{ $batch->file->fileUrl('filename') }}" target="_blank" class="text-xs md:text-base text-indigo-500 underline">
                                Sertifikat
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</x-member-layout>