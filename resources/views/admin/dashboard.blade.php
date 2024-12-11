<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @if(session('success'))
        <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    @if(Auth::user()->is_member && !Auth::user()->member->isCompleted())
        <x-alert type="warning">Mohon lengkapi data pribadi anda, <a href="{{ route('member.profile') }}" class="text-blue-500 pointer">klik disini</a></x-alert>
    @endif

    @foreach(Auth::user()->unreadNotifications()->take(5) as $notification)
        <x-alert type="info"><a href="{{ $notification->data['link'] }}" class="text-blue-500 pointer">{{ $notification->data['message']}}</a></x-alert>
    @endforeach

    @if(isset($queues) && $queues)
      <x-alert type="info">Sedang memproses pengiriman {{ $queues }} email. <a href="{{ route('admin.jobs.index') }}" class="text-yellow-500 pointer">(selengkapnya)</a></x-alert>
    @endif

    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach($courses as $course)
      @if($course->lastBatch())
      @php
      $openBatch = $course->lastBatch();
      @endphp
      <section class="text-gray-600 body-font">
        <div class="container px-5 py-8 mx-auto">
          <div class="flex flex-wrap -m-4 text-center bg-white">
            <a href="{{ route('admin.courses.batches.members',[$openBatch->course_id, $openBatch->id]) }}" class="w-full pt-2 block text-lg font-bold text-gray-500 pointer mx-1">Kelas {{ $openBatch->full_name }}</a>
            @if($openBatch->is_open)
            <p class="w-full pt-2 block text-l font-bold text-green-500 pointer mx-1">[ Pendaftaran Dibuka ]</p>
            @elseif($openBatch->is_active)
            <p class="w-full pt-2 block text-l font-bold text-yellow-500 pointer mx-1">[ Status: Kelas Sedang Berlangsung ]</p>
            @elseif($openBatch->is_finished)
            <p class="w-full pt-2 block text-l font-bold text-blue-500 mx-1">[ Kelas Selesai ]</p>
            @else
            <p class="w-full pt-2 block text-l font-bold text-grey-500 mx-1">[ Kelas Belum dibuka ]</p>
            @endif
            <p class="w-full pt-2 block text-sm text-gray-700">Pendaftaran : {{ $openBatch->registration_duration }}</p>
            <p class="w-full pt-2 block text-sm text-gray-700">Kelas : {{ $openBatch->duration }}</p>
            <p class="w-full pt-2 block text-sm text-gray-700">Total Peserta : {{ $openBatch->members()->count() }} orang</p>
            @foreach($batchStatuses as $status)
            <div class="p-4 sm:w-1/3 w-1/2">
              <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">{{ $openBatch->members()->wherePivot('status', $status)->count() }}</h2>
              <p class="leading-relaxed">{{ __('batch.status_'.$status)}}</p>
            </div>
            @endforeach
            <div class="w-full pt-2 block mb-2">
              <x-link-button href="{{ route('admin.courses.queues.index',[$openBatch->course_id]) }}">Waiting List</x-link-button>
              <x-link-button type="success" href="{{ route('admin.courses.batches.members',[$openBatch->course_id, $openBatch->id]) }}">data peserta</x-link-button>
              <x-link-button type="warning" href="{{ route('admin.courses.batches.index',[$openBatch->course_id]) }}">Semua Angkatan</x-link-button>
            </div>
          </div>
        </div>
      </section>
      @endif
    @endforeach
    </div>

    <section class="text-gray-600 body-font">
      <div class="container px-5 py-8 mx-auto">
        <div class="flex flex-wrap -m-4 text-center bg-white">
          <p class="w-full pt-2 block text-lg font-bold text-gray-700">Statistik Data Keseluruhan</p>
          <div class="p-4 sm:w-1/4 w-1/2">
            <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">{{ $all_members }}</h2>
            <p class="leading-relaxed">Anggota</p>
          </div>
          <div class="p-4 sm:w-1/4 w-1/2">
            <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">{{ $all_courses }}</h2>
            <p class="leading-relaxed">Kelas</p>
          </div>
          <div class="p-4 sm:w-1/4 w-1/2">
            <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">{{ $all_batches }}</h2>
            <p class="leading-relaxed">Batch</p>
          </div>
          <div class="p-4 sm:w-1/4 w-1/2">
            <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">{{ $all_events }}</h2>
            <p class="leading-relaxed">Event</p>
          </div>
        </div>
      </div>
    </section>
</x-app-layout>