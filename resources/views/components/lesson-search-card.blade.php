@props(['lesson'])

<div class="w-full md:w-1/3 p-4">
    <a href="{{ route('member.ecourses.lessons', ['slug' => $lesson->ecourse->slug, 'lesson' => $lesson->lesson_uu]) }}" class="ecourse" title="{{ $lesson->subject }}">
        <div class="rounded-lg">
            <img class="rounded-lg border border-gray-200 w-full object-cover object-center mb-6" src="{{ $lesson->imageUrl('thumbnail') }}" alt="{{ $lesson->subject }}"
            onerror="this.onerror=null; this.src='{{ asset('images/placeholder.png') }}';">
            <h2 class="text-xs md:text-base text-gray-900 font-medium title-font mb-2">{{ $lesson->subject }}</h2>
            <p class="text-xs md:text-base text-gray-500">{{ $lesson->ecourse->title }}</p>
        </div>
    </a>
</div>
