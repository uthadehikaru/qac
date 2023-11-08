<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ $ecourse->title }}
        </h2>
        <div class="float-right">
            <x-link-button  href="{{ route('admin.ecourses.index') }}" class=" ml-3" type="warning">Back</x-button>
            <x-link-button  href="{{ route('admin.ecourses.lessons.create', $ecourse->id) }}" class=" ml-3">@lang('New Lesson')</x-button>
        </div>
    </x-slot>

    <x-panel>
        <div class="mx-auto flex flex-col gap-y-8 mt-4">
            <h2 class="font-bold text-2xl">Lessons</h2>
            @forelse ($ecourse->lessons as $lesson)
                <div class="w-full flex gap-x-4" id="lesson-{{ $lesson->id }}">
                    <img class="w-1/4" src="{{ $lesson->imageUrl('thumbnail') }}" alt="{{ $lesson->subject }}" />
                    <div class="flex flex-col gap-y-4">
                        <span class="font-bold text-xl">{{ $loop->iteration }}. {{ $lesson->subject }}</span>
                        <span class="">Section : {{ $lesson->section->name }}</span>
                        <span class="">File : {{ $lesson->file?->type }}</span>
                        <div>
                            <a href="{{ route('admin.ecourses.lessons.edit', [$ecourse->id, $lesson->id]) }}" class="text-white bg-yellow-500 p-2 rounded">Edit</a>
                            <a href="#" data-id="{{ $lesson->id }}" class="text-white delete bg-red-500 p-2 rounded">Delete</a>
                        </div>
                    </div>
                </div>
            @empty
                <span class="italic text-blue-500">No lessons found, <a href="{{ route('admin.ecourses.lessons.create', $ecourse->id) }}">Create One</a></span>
            @endforelse
        </div>
    </x-panel>
    <x-slot name="scripts">
        <script type="text/javascript">
            $(document).on('click', '.delete', function (e) {
                e.preventDefault();

                if(confirm("Delete this record?")) {
                    var id = $(this).data("id");
                    var token = $("meta[name='csrf-token']").attr("content");
                
                    $.ajax(
                    {
                        url: "{{ route('admin.ecourses.lessons.index', $ecourse->id) }}/"+id,
                        type: 'DELETE',
                        data: {
                            "id": id,
                            "_token": token,
                        },
                        success: function (data){
                            $('#lesson-'+id).remove();
                            alert(data.status);
                        }
                    });
                }
            });
        </script>
    </x-slot>
</x-app-layout>