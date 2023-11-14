<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('member.ecourses.show', $ecourse->slug) }}" class="text-blue-500 font-semibold text-xl text-gray-800 leading-tight inline">
            {{ $ecourse->title }}
        </a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            - {{ $video->subject }}
        </h2>
    </x-slot>

    <x-panel>
        <div class="container mx-auto">
            <div class="w-full flex gap-x-2">
                <div class="lg:w-2/3">
                    <video width="100%" height="240" controls autoplay controlsList="nodownload">
                    <source src="{{ asset('storage/'.$video->file->filename) }}" type="video/mp4">
                    Your browser does not support the video tag.
                    </video>
                </div>
                <div class="lg:w-1/3 flex flex-col gap-y-2">
                    @foreach ($videos as $lesson)
                        <x-lesson-card :video="$lesson" :ecourse="$ecourse" :completed="$completed" />
                    @endforeach
                </div>
            </div>
            <div class="w-full flex gap-x-2 p-6">
                <div class="lg:w-2/3 flex flex-col gap-y-8 mt-4 p-4">
                    @if($completed->contains($video->id))
                        <button type="button" class="w-full rounded border border-blue-500 font-bold text-blue-500 text-center p-4" disabled>Completed</button>
                    @else
                    <form method="POST" id="complete-form" action="{{ route('member.ecourses.lessons.complete', [$ecourse->slug, $video->lesson_uu]) }}">
                        @csrf
                        <button type="submit" class="w-full rounded bg-blue-500 font-bold text-white text-center p-4 hover:bg-blue-400">Complete</button>
                    </form>
                    @endif
                    @if($next)
                    <h3 class="font-bold text-xl">Next</h3>
                    <x-lesson-card :video="$next" id="next" :ecourse="$ecourse" :completed="$completed" />
                    @else
                    <h3 class="font-bold text-xl">End of Lesson</h3>
                    @endif
                </div>
                <div class="lg:w-1/3 flex flex-col mt-4">
                    <div class="">
                        <p class="text-lg font-bold ">Downloads</p>
                        <ul class="list-decimal pl-4 mt-2">
                        @foreach ($video->getMedia('downloads') as $media)
                            <li class="p-2"><a href="{{ $media->getFullUrl() }}" class="text-blue-500">{{ $media->file_name }}</a></li>
                        @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
</x-panel>
<x-slot name="scripts">
<script>/*<![CDATA[*/
  $(document).ready(function(){
    $('video').on('ended',function(){
        @if($completed->contains($video->id))
            $('#next')[0].click();
        @else
            $('#complete-form').submit();
        @endif
    });
  });
/*]]>*/</script>
</x-slot>
</x-app-layout>