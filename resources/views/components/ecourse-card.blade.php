<div class="bg-gray-100 p-6 rounded-lg">
    <a href="{{ route('member.ecourses.show', $ecourse->slug) }}"><img class="
        rounded w-full object-cover object-center mb-6" src="{{ $ecourse->imageUrl('thumbnail') }}" alt="content" /></a>
    <h2 class="text-lg text-gray-900 font-bold title-font mb-4">{{ $ecourse->title }}</h2>
    <p class="leading-relaxed text-base mb-4">{{ $ecourse->description }}</p>
    <h2 class="font-bold text-md">{{ $ecourse->completed }} of {{ $ecourse->lessons->count() }} Lessons Completed</h2>                    
    <div class="w-full rounded-full h-2.5 bg-gray-300 mt-2">
        <div class="bg-red-800 h-2.5 rounded-full" style="width: {{ $ecourse->lessons->count() ? round(($ecourse->completed/$ecourse->lessons->count())*100):0 }}%"></div>
    </div>
    <div class="flex justify-center mt-4">
        <a href="{{ route('member.ecourses.show', $ecourse->slug) }}" class="bg-red-800 rounded rounded-full p-2 text-white hover:opacity-75">Start Course</a>
    </div>
</div>