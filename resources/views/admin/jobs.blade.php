<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Email Processor') }}
        </h2>
    </x-slot>

    @if(session()->has('message'))
        <x-alert type="success">{{ session('message') }}</x-alert>
    @endif
    @if(session()->has('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
    @endif

    <section class="text-gray-600 body-font bg-white">
        <div class="container px-5 py-24 mx-auto">
            <div class="flex flex-wrap -m-4 text-center">
                <div class="p-4 md:w-1/2 w-full">
                    <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-blue-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    <h2 class="title-font font-medium text-3xl text-gray-900">{{ $jobs }}</h2>
                    <p class="leading-relaxed">Sedang dikirim</p>
                    </div>
                </div>
                <div class="p-4 md:w-1/2 w-full">
                    <div class="border-2 border-gray-200 px-4 py-6 rounded-lg">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="text-red-500 w-12 h-12 mb-3 inline-block" viewBox="0 0 24 24">            
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h2 class="title-font font-medium text-3xl text-gray-900">{{ $failed_jobs->count() }}</h2>
                    <p class="leading-relaxed">Gagal dikirim</p>
                    @if($failed_jobs->count()>0)
                    <a href="{{ route('admin.jobs.retry') }}" class="pointer text-blue-500 underline">Proses ulang</a>
                    <a href="{{ route('admin.jobs.empty') }}" class="pointer text-blue-500 underline">Kosongkan</a>
                    @endif
                    </div>
                </div>
            </div>

            <div class="m-6">
                <p class="block text-lg font-bold text-gray-700">Failed Jobs</p>
                    <div class="shadow overflow-hidden border border-gray-200 sm:rounded-lg">

                        <table class="table-auto w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>

                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Connection
                                    </th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Queue
                                    </th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Exception
                                    </th>
                                    <th class="px-2 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Payload
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white text-xs divide-y divide-gray-200">
                                @foreach($failed_jobs as $failed_job)
                                <tr>

                                    <td class="px-2 py-4 whitespace-nowrap align-top">
                                        {{ $failed_job->connection }}
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap align-top">
                                        {{ $failed_job->queue }}
                                    </td>
                                    <td class="px-2 py-4 align-top">
                                        {!! nl2br($failed_job->exception) !!}
                                    </td>
                                    <td class="px-2 py-4 align-top">
                                        {!! nl2br($failed_job->payload) !!}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        </div>
    </section>
</x-app-layout>