<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __('Course Detail') }}
        </h2>
    </x-slot>

    <div class="w-full mt-4 py-6">
        <div class="flex">
            @foreach($statuses as $status)
            @if($status==0)
                @continue
            @endif
            <div class="w-1/{{ count($statuses)-1 }}">
                <div class="relative mb-2">
                    @if($status>1)
                    <div class="absolute flex align-center items-center align-middle content-center" style="width: calc(100% - 2.5rem - 1rem); top: 50%; transform: translate(-50%, -50%)">
                    <div class="w-full bg-gray-200 rounded items-center align-middle align-center flex-1">
                        <div class="w-0 bg-green-300 py-1 rounded" style="width: {{ $batchMember->status>=$status?100:0 }}%;"></div>
                    </div>
                    </div>
                    @endif

                    <div class="w-10 h-10 mx-auto bg-{{ $batchMember->status>=$status?'green-300':'white border-2 border-gray-200' }} rounded-full text-lg text-white flex items-center">
                    <span class="text-center text-{{ $batchMember->status>=$status?'white':'gray-600' }} w-full">
                        <svg class="w-full fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path class="heroicon-ui" d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm0-2a8 8 0 1 0 0-16 8 8 0 0 0 0 16zm-2.3-8.7l1.3 1.29 3.3-3.3a1 1 0 0 1 1.4 1.42l-4 4a1 1 0 0 1-1.4 0l-2-2a1 1 0 0 1 1.4-1.42z"/>
                        </svg>
                    </span>
                    </div>
                </div>
                <div class="text-xs text-center md:text-base">@lang('batch.status_'.$status)</div>
            </div>
            @endforeach
        </div>
    </div>

    @if(session('success'))
        <x-alert type="success">{!! session('success') !!}</x-alert>
    @endif

    @if($batchMember->batch->course->level==1 && $batchMember->status<3)
    <x-alert type="success" title="Berhasil">
    silahkan menghubungi Admin QAC via whatsapp untuk proses administrasi. <a target="_blank" href="https://wa.me/{{ \App\Models\System::value('whatsapp') }}?text={{ urlencode('Assalaamu\'alaikum QAC, saya sudah mendaftar '.$batchMember->batch->full_name.' atas nama '.$batchMember->member->full_name.'. mohon dibantu untuk proses selanjutnya. terima kasih') }}" class="text-blue-500 cursor-pointer">klik disini</a>
    </x-alert>
    @endif

    
    @if($batchMember->status>0 && $batchMember->status<4)
    <x-alert type="error" title="Perhatian"><p>Kami akan mengirimkan modul pembelajaran ke alamat anda, pastikan telah sesuai dengan alamat tempat tinggal anda saat ini!
        <br/><br/>
        <span class="text-black">{{ $member->full_name }} ({{ $member->phone }}) - {{ $member->address }}</span></p>
        <p><a href="{{ route('member.profile') }}" class="pointer text-blue-500"> (klik disini untuk memperbaharui alamat)</a>
        </x-alert>
    @endif

    <x-panel>
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ $batchMember->batch->full_name }} {{ $batchMember->session }}
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                {{ $batchMember->batch->duration }}
                </p>
            </div>
            <div class="border-t border-gray-200">
                <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Deskripsi
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">
                    {{ $batchMember->batch->course->description }}
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Jadwal
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">
                    {{ $batchMember->batch->description }}
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Lampiran
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">
                    <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                        @if($batchMember->batch->file)
                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <!-- Heroicon name: solid/paper-clip -->
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-2 flex-1 w-0 truncate">
                            {{ $batchMember->batch->file->name }}
                            </span>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="{{ $batchMember->batch->file->fileUrl('filename') }}" 
                            target="_blank" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Unduh
                            </a>
                        </div>
                        </li>
                        @endif
                        @if($batchMember->file)
                        <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                        <div class="w-0 flex-1 flex items-center">
                            <!-- Heroicon name: solid/paper-clip -->
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-2 flex-1 w-0 truncate">
                            {{ $batchMember->file->name }}
                            </span>
                        </div>
                        <div class="ml-4 flex-shrink-0">
                            <a href="{{ $batchMember->file->fileUrl('filename') }}" 
                            target="_blank" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Unduh
                            </a>
                        </div>
                        </li>
                        @endif
                    </ul>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-4 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">
                    Modul
                    </dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-3">
                    <ul class="border border-gray-200 rounded-md divide-y divide-gray-200">
                        @foreach($batchMember->batch->course->modules()->orderBy('module_no')->get() as $module)
                        @if($batchMember->status>=$module->member_status)
                            <li class="pl-3 pr-4 py-3 flex items-center justify-between text-sm">
                            <div class="w-0 flex-1 flex items-center">
                                <!-- Heroicon name: solid/paper-clip -->
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd" />
                                </svg>
                                <span class="ml-2 flex-1 w-0 truncate">
                                {{ $module->name }}
                                </span>
                            </div>
                            <div class="ml-4 flex-shrink-0">
                                <a href="{{ $module->file->fileUrl('filename') }}" 
                                target="_blank" class="font-medium text-indigo-600 hover:text-indigo-500">
                                Unduh
                                </a>
                            </div>
                            </li>
                        @endif
                        @endforeach
                    </ul>
                    </dd>
                </div>
                </dl>
            </div>
        </div>
    </x-panel>
</x-app-layout>