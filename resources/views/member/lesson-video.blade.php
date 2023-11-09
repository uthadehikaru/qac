<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ $video->subject }}
        </h2>
    </x-slot>

    <x-panel>
        <div class="container mx-auto">
            <div class="w-full flex gap-x-2">
                <div class="lg:w-2/3">
                    <video width="100%" height="240" controls controlsList="nodownload">
                    <source src="{{ asset('storage/'.$video->file->filename) }}" type="video/mp4">
                    Your browser does not support the video tag.
                    </video>
                </div>
                <div class="lg:w-1/3 flex flex-col gap-y-2">
                    @foreach ($ecourse->lessons as $lesson)
                        <div class="w-full flex gap-x-4">
                            <img class="w-1/4" src="{{ $lesson->imageUrl('thumbnail') }}" alt="{{ $lesson->subject }}" />
                            <a href="{{ route('member.ecourses.lessons', [$ecourse->slug, $lesson->lesson_uu]) }}" 
                            class="font-bold
                            {{ $completed->contains($lesson->id)?'text-blue-500':'' }}
                            ">{{ $lesson->subject }}</a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="w-full flex gap-x-2 p-6">
                <div class="lg:w-2/3 flex flex-col gap-y-8 mt-4 p-4">
                    @if($completed->contains($video->id))
                        <button type="button" class="w-full rounded border border-blue-500 font-bold text-blue-500 text-center p-4" disabled>Completed</button>
                    @else
                    <form method="POST" action="{{ route('member.ecourses.lessons.complete', [$ecourse->slug, $video->lesson_uu]) }}">
                        @csrf
                        <button type="submit" class="w-full rounded bg-blue-500 font-bold text-white text-center p-4 hover:bg-blue-400">Complete</button>
                    </form>
                    @endif
                </div>
                <div class="lg:w-1/3 flex flex-col mt-4">
                    <div class="">
                        <p class="text-lg font-bold">Downloads</p>
                        <p>untuk bantuan lebih lengkap, silahkan hubungi whatsapp kami</p>
                    </div>

                </div>
            </div>
        </div>
</x-panel>
</x-app-layout>