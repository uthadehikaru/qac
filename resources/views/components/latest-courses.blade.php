<section id="courses" class="bg-gray-100 pt-6 py-8" style="background: url(images/bg.jpg);background-repeat: no-repeat;background-size: cover;">
        <div class="container mx-auto px-2 pt-4 pb-2 text-gray-800">
        <div class="flex flex-wrap -m-4">
            @foreach($courses as $course)
            <div class="p-8 md:w-1/3">
                <div class="h-full border-2 align-center border-gray-200 border-opacity-60 rounded-lg overflow-hidden">
                    <div class="">
                        <a href="{{ route('register', ['course_id'=>$course->id]) }}" class="">
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