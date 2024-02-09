<div class="w-full flex gap-x-4">
    <img class="w-1/4" src="{{ $video->imageUrl('thumbnail') }}" alt="{{ $video->subject }}" />
    <a id="{{ $id ?? $video->lesson_uu }}" href="{{ route('member.ecourses.lessons', [$ecourse->slug, $video->section_id, $video->lesson_uu]) }}" 
    class="font-bold flex items-center
    {{ isset($completed) && $completed->contains($video->id)?'text-gray-800':'text-red-800' }}
    ">
    @if(isset($current) && $current->lesson_uu==$video->lesson_uu)
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
    <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.347a1.125 1.125 0 0 1 0 1.972l-11.54 6.347a1.125 1.125 0 0 1-1.667-.986V5.653Z" />
    </svg>
    @endif
    {{ $video->subject }}</a>
</div>