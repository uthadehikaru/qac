<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __('Member') }} - {{ $member->name }}
        </h2>
        <div class="float-right">
        {{ $member->user->email }} | {{ $member->phone }}
        </div>
        <p class="">Pendidikan {{ $member->pendidikan }} | Profesi {{ $member->profesi }}</p>
        <p class="">Alamat : {{ $member->address }}</p>
    </x-slot>

    <div class="m-6">
        <p class="block text-lg font-bold text-gray-700">Kelas yang diikuti</p>
        <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

            <table class="w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>

                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kelas
                        </th>
                        <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            jadwal
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
                    @foreach($member->batches as $batch)
                    <tr>

                        <td class="px-2 py-4 whitespace-nowrap">
                            {{ $batch->full_name }} {{ $batch->pivot->session }}
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap">
                            {{ $batch->duration }}
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap">
                            @lang('batch.status_'.$batch->pivot->status)
                        </td>
                        <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500">

                            <div class="flex justify-start space-x-1">
                                <a href="{{ route('admin.courses.batches.members.edit', [$batch->course_id,$batch->id,$batch->pivot->id]) }}" class="border-2 border-indigo-200 rounded-md p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-indigo-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                @if($batch->pivot->file)
                                <a href="{{ $batch->pivot->file->fileUrl('filename') }}" target="_blank" class="border-2 border-indigo-200 rounded-md p-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-indigo-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </a>
                                @endif
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>