<section id="courses" class="bg-gray-100 pt-6 py-8 background"">
        <div class="container mx-auto px-2 pt-4 pb-2 text-gray-800">
            <div class="text-center mb-20">
                <h1 class="text-3xl md:text-5xl font-bold text-center text-gray-900 mb-4">
                Pilihan Kelas
                </h1>
                <div class="w-full mb-4">
                <div class="h-1 mx-auto gradient w-64 opacity-25 my-0 py-0 rounded-t"></div>
                </div>
            </div>
            <div class="flex flex-wrap -m-4">
                @foreach($courses as $course)
                <div class="p-8 md:w-1/3">
                    <div class="h-full border-2 align-center border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                        <div class="">
                            @if(auth()->check())
                            <a href="{{ route('member.dashboard') }}#courses" class="">
                            @else
                            <a href="{{ route('register', ['course_id'=>$course->id]) }}" class="">
                            @endif
                                <img class="w-full object-cover object-center" 
                                src="{{ asset('images/'.$course->name.'.jpg') }}" alt="{{ $course->name }}" />
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        </section>