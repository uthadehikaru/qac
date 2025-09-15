<section class="text-gray-600 body-font">
    <div class="container px-5 py-8 mx-auto">
        <div class="flex flex-wrap -m-4 text-center bg-white">
        <a href="{{ route('admin.courses.batches.members',[$openBatch->course_id, $openBatch->id]) }}" class="w-full pt-2 block text-lg font-bold text-gray-500 pointer mx-1">Kelas {{ $openBatch->full_name }}</a>
        @if(!$course->is_lite)
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
        @endif
        <p class="w-full pt-2 block text-sm text-gray-700">Total Peserta : {{ $openBatch->members()->count() }} orang</p>
        @foreach($batchStatuses as $status)
        @if($course->is_lite)
            @if(in_array($status, [4, 5]))
                @continue
            @endif
        @endif
        <div class="p-4 w-1/2 {{ $course->is_lite ? 'md:w-1/4' : 'md:w-1/3' }}">
            <h2 class="title-font font-medium sm:text-4xl text-3xl text-gray-900">{{ $openBatch->members()->wherePivot('status', $status)->count() }}</h2>
            <p class="leading-relaxed">{{ __('batch.status_'.$status)}}</p>
        </div>
        @endforeach
        <div class="w-full pt-2 block mb-2">
            @if(!$course->is_lite)
            <x-link-button href="{{ route('admin.courses.queues.index',[$openBatch->course_id]) }}">Waiting List</x-link-button>
            <x-link-button type="warning" href="{{ route('admin.courses.batches.index',[$openBatch->course_id]) }}">Semua Angkatan</x-link-button>
            @endif
            <x-link-button type="success" href="{{ route('admin.courses.batches.members',[$openBatch->course_id, $openBatch->id]) }}">data peserta</x-link-button>
        </div>
        </div>
    </div>
</section>