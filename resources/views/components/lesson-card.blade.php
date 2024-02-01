<div class="w-full flex gap-x-4">
    <img class="w-1/4" src="{{ $video->imageUrl('thumbnail') }}" alt="{{ $video->subject }}" />
    <a id="{{ $id ?? $video->lesson_uu }}" href="{{ route('member.ecourses.lessons', [$ecourse->slug, $video->section_id, $video->lesson_uu]) }}" 
    class="font-bold
    {{ isset($completed) && $completed->contains($video->id)?'text-gray-800':'text-blue-500' }}
    ">{{ $video->subject }}</a>
</div>