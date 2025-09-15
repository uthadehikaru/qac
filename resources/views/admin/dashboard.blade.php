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

    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 gap-4">
    @foreach($courses as $course)
      @if(!$course->is_lite)
        @continue
      @endif
      @php
      $openBatch = $course->lastBatch();
      @endphp
      <x-admin-batch-card :openBatch="$openBatch" :course="$course" :batchStatuses="$batchStatuses" />
    @endforeach
    </div>

    <div class="container mx-auto grid grid-cols-1 md:grid-cols-3 gap-4">
    @foreach($courses as $course)
      @if($course->is_lite)
        @continue
      @endif
      @if($course->lastBatch())
      @php
      $openBatch = $course->lastBatch();
      @endphp
      <x-admin-batch-card :openBatch="$openBatch" :course="$course" :batchStatuses="$batchStatuses" />
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