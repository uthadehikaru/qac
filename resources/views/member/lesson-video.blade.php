<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('member.ecourses.index') }}" class="text-red-800 font-semibold text-gray-800 leading-tight inline">
            My Courses
        </a>
        <a href="{{ route('member.ecourses.show', $ecourse->slug) }}" class="text-red-800 font-semibold text-gray-800 leading-tight inline">
            / {{ $ecourse->title }}
        </a>
        <h2 class="font-semibold text-gray-800 leading-tight inline">
            / Sesi / {{ $section->name }}
        </h2>
        <h2 class="font-semibold text-gray-800 leading-tight inline">
            / {{ $video->subject }}
        </h2>
    </x-slot>

    <x-panel>
        <div class="container mx-auto">
            <div class="w-full flex flex-col md:flex-row gap-x-2">
                <div class="content md:w-2/3">
                    <video width="100%" height="240" controls autoplay controlsList="nodownload">
                    <source src="{{ route('member.ecourses.lessons.video', [$ecourse->slug, $video->lesson_uu]) }}" type="video/mp4">
                    Your browser does not support the video tag.
                    </video>
                </div>
                <div class="md:w-1/3 flex flex-col gap-y-2">
                    <div class="flex justify-between border-b py-4 bg-gray-200 px-2">
                        <p class="font-bold text-gray-800">{{ $section->name }}</p>
                        <p class="text-gray-600">{{ $videos->count() }} Lessons</p>
                    </div>
                    @foreach ($videos as $lesson)
                        <x-lesson-card :video="$lesson" :ecourse="$ecourse" :completed="$completed"
                        :current="$video" />
                    @endforeach
                </div>
            </div>
            <div class="w-full flex flex-col md:flex-row gap-x-2 p-6">
                <div class="md:w-2/3 flex flex-col gap-y-8 mt-4 p-4">
                    <p>{{ $video->description }}</p>
                    @if(auth()->user()->role != 'admin')
                        @if($completed->contains($video->id))
                            <button type="button" class="w-full rounded border border-red-800 font-bold text-red-800 text-center p-4" disabled>Completed</button>
                        @else
                        <form method="POST" id="complete-form" action="{{ route('member.ecourses.lessons.complete', [$ecourse->slug, $video->lesson_uu]) }}">
                            @csrf
                            <button type="submit" class="w-full rounded bg-red-800 font-bold text-white text-center p-4 hover:opacity-75">Complete</button>
                        </form>
                        @endif
                    @endif
                    @if($next)
                    <h3 class="font-bold text-xl">Next</h3>
                    <x-lesson-card :video="$next" id="next" :ecourse="$ecourse" :completed="$completed" />
                    @else
                    <h3 class="font-bold text-xl">End of Lesson</h3>
                    @endif
                </div>
                <div class="md:w-1/3 flex flex-col mt-4">
                    <div class="">
                        <p class="text-lg font-bold ">Downloads</p>
                        <ul class="list-decimal pl-4 mt-2">
                        @foreach ($video->getMedia('downloads') as $media)
                            <li class="p-2"><a href="{{ $media->getFullUrl() }}" target="_blank" class="text-red-800">{{ $media->file_name }}</a></li>
                        @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
</x-panel>
<x-slot name="styles">
    <style>
        .content {
        position: relative;
        margin: 0 auto;
        }
        .content video {
        width: 100%;
        display: block;
        }
        /* .content:before {
        content: '';
        position: absolute;
        background: rgba(0, 0, 0, 0.5);
        border-radius: 5px;
        z-index : 2;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        } */
    </style>
</x-slot>
<x-slot name="scripts">
<script>/*<![CDATA[*/
  $(document).ready(function(){
    document.addEventListener('contextmenu', event => event.preventDefault());
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