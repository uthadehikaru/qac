<x-app-layout>
    <x-slot name="header">
        <a href="{{ route('admin.ecourses.index') }}" class="font-semibold text-xl text-blue-500 leading-tight inline">
            Online Courses
        </a>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            - {{ $ecourse->title }}
        </h2>
        <div class="float-right flex flex-row">
            <x-link-button  href="{{ route('admin.ecourses.index') }}" class=" ml-3" type="warning">Back</x-button>
            <x-link-button  href="{{ route('admin.ecourses.subscriptions.index', $ecourse->id) }}" type="success" class=" ml-3">@lang('Subscribers')</x-button>
            <x-link-button  href="{{ route('admin.ecourses.lessons.create', $ecourse->id) }}" class=" ml-3">@lang('New Lesson')</x-button>
        </div>
    </x-slot>

    
        <div class="bg-white p-2 w-full mx-auto flex flex-col gap-y-8 mt-4">
            <h2 class="font-bold text-2xl">Lessons</h2>
            @forelse ($ecourse->lessons->sortBy('order_no') as $lesson)
                <div class="w-full flex flex-col md:flex-row gap-x-4" id="lesson-{{ $lesson->id }}">
                    <div  class="w-full mb-2 md:w-1/4">
                        <img src="{{ $lesson->imageUrl('thumbnail') }}" alt="{{ $lesson->subject }}" />
                    </div>
                    <div class="flex flex-col gap-y-4">
                        <span class="font-bold text-xl">{{ $lesson->order_no }}. {{ $lesson->subject }}</span>
                        <span class="">Section : {{ $lesson->section->name }}</span>
                        <span class="">Video : {{ $lesson->getMedia('videos')->first()?->name ?? 'no video' }}</span>
                        <span class="">Downloads : </span>
                        <ul class="list-decimal pl-4">
                            @forelse ($lesson->getMedia('downloads') as $media)
                                <li><a href="{{ $media->getFullUrl() }}" class="text-blue-500">{{ $media->file_name }}</a></li>
                            @empty
                                No Files
                            @endforelse
                        </ul>
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