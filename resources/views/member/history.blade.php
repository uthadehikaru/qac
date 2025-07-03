<x-member-layout>
    <div class="m-6">
        <div class="flex flex-wrap -m-4">
            @forelse ($histories as $history)
            <div class="w-full md:w-1/2 lg:w-1/3 p-4">
                <a href="{{ route('member.ecourses.lessons', [$history->lesson->ecourse->slug, $history->lesson->lesson_uu]) }}" class="ecourse" title="{{ $history->lesson->ecourse->title }}">
                    <div class="rounded-lg">
                        <img class="rounded-lg border border-gray-200 w-full h-64 object-cover object-center mb-6" src="{{ $history->lesson->ecourse->imageUrl('thumbnail') }}" alt="{{ $history->lesson->ecourse->title }}">
                        <h2 class="text-xs text-gray-900 font-medium title-font mb-2">{{ $history->lesson->subject }}</h2>
                        <p class="text-xs text-gray-500">terakhir ditonton {{ $history->updated_at->diffForHumans() }}</p>
                    </div>
                </a>
            </div>
            @empty
            <div class="text-center">
                Mulai belajar sekarang!
            </div>
            @endforelse
        </div>
        <div class="mt-6">
            {{ $histories->links() }}
        </div>
    </div>
</x-member-layout>