<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(!Auth::user()->member->isCompleted())
        <x-alert type="warning">Mohon lengkapi data pribadi anda, <a href="{{ route('member.profile') }}" class="text-blue-500 pointer">klik disini</a></x-alert>
    @endif

    <div class="p-6 grid grid-cols-2 gap-4">
        <div class="m-6">
            <p class="block text-lg font-bold text-gray-700">Your Courses</p>
            <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>

                            <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Course
                            </th>

                            <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>

                            <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white text-xs divide-y divide-gray-200">
                        @foreach($batches as $batch)
                        <tr>

                            <td class="px-2 py-4 whitespace-nowrap">
                                {{ $batch->batch->name }} {{ $batch->session }}
                            </td>

                            <td class="px-2 py-4 whitespace-nowrap">
                                {{ $batch->approved_at?'Approved at '.$batch->approved_at->format('d-M-Y H:i'):'Not Approved' }}
                            </td>

                            <td class="px-2 py-4 whitespace-nowrap text-sm text-gray-500">

                                <div class="flex justify-start space-x-1">
                                    <a href="{{ route('member.batches.detail', $batch->id) }}" class="border-2 border-indigo-200 rounded-md p-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4 text-indigo-500">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                </div>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>