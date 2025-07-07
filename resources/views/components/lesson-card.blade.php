<div class="w-full flex flex-col gap-y-2">
    <img class="w-full md:w-3/4" src="{{ $video->imageUrl('thumbnail') }}" alt="{{ $video->subject }}" />
    <a id="{{ $id ?? $video->lesson_uu }}" href="{{ route('member.ecourses.lessons', [$ecourse->slug, $video->lesson_uu]) }}" 
    class="font-bold flex items-center w-full py-4 text-red-800">
    {{ $video->subject }}</a>
</div>