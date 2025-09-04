<div class="w-full">
    <a id="{{ $id ?? $video->lesson_uu }}" href="{{ route('member.ecourses.lessons', ['slug' => $ecourse->slug, 'lesson'=>$video->lesson_uu, 'section'=>$video->section_id]) }}" 
    class="font-bold flex flex-col gap-y-2 items-start justify-start w-full py-4 {{ $current->lesson_uu == $video->lesson_uu ? 'text-yellow-500' : 'text-red-800' }} hover:text-yellow-500">
    <img class="w-full md:w-3/4" src="{{ $video->imageUrl('thumbnail') }}" alt="{{ $video->subject }}" />
    <span class="text-sm">{{ $video->subject }}</span>
    </a>
</div>