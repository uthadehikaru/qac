<x-web-layout>

    <x-panel class="mt-20">
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ $ecourse->level ? route('ecourses.index') : route('event.list') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-3 h-3 mr-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                        </svg>
                        {{ $ecourse->level ? 'Program Alumni' : 'Event QAC' }}
                    </a>
                </li>
                @if($ecourse->category)
                <li class="inline-flex items-center">
                    <a href="{{ $ecourse->level ? route('ecourses.index', ['category' => $ecourse->category->slug]) : route('event.list', ['category' => $ecourse->category->slug]) }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        {{ $ecourse->category->name }}
                    </a>
                </li>
                @endif
                <li aria-current="page">
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                        </svg>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">{{ $ecourse->title }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        <div class="container mx-auto">
            <div class="w-full flex flex-col md:flex-row gap-8">
                <div class="content md:w-2/3">
                    <video width="100%" height="240" controls autoplay controlsList="nodownload">
                    <source src="{{ route('member.ecourses.lessons.video', [$ecourse->slug, $video->lesson_uu]) }}" type="video/mp4">
                    Your browser does not support the video tag.
                    </video>
                    <p class="mt-8">{{ $video->description }}</p>
                    <div class="mt-8">
                        <p class="text-lg font-bold ">Download Theory, Workbook & Daily Activities:</p>
                        <ul class="list-decimal pl-4 mt-2">
                        @foreach ($video->getMedia('downloads') as $media)
                            <li class="p-2"><a href="{{ $media->getFullUrl() }}" target="_blank" class="text-red-800">{{ $media->file_name }}</a></li>
                        @endforeach
                        </ul>
                    </div>

                </div>
                <div class="md:w-1/3 mt-8 md:mt-0 flex flex-col gap-y-2">
                    @foreach ($videos as $lesson)
                        <x-lesson-card :video="$lesson" :ecourse="$ecourse" :completed="$completed"
                        :current="$video" />
                    @endforeach
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
</x-web-layout>