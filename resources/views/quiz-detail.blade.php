<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" id="form" action="{{ route('quiz.finish', $quiz->slug) }}">
            @csrf
            <h2 class="text-center font-bold text-xl">{{ $quiz->name }}</h2>
            <p class="mb-4 text-center text-sm">sisa waktu : <span id="counter">99:99:99</span></p>
            @foreach($quiz->questions as $question)
            <div class="mb-4">
            <p class="mb-2">{{ $i++ }}. {{ $question->content }}</p>
            @foreach($options as $option)
            <p><input type="radio" class="mr-2" name="question_{{ $question->id }}" value="{{ $option }}" />{{ Str::upper($option) }}. {{ $question->getOriginal('option_'.$option) }}</p>
            @endforeach
            </div>
            @endforeach
            

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-3">
                    {{ __('Kirim Jawaban') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        // Set the date we're counting down to
        var countDownDate = new Date("{{ $end_at }}").getTime();

        // Update the count down every 1 second
        var x = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        if(hours<10)
            hours = "0"+hours;
        if(minutes<10)
            minutes = "0"+minutes;
        if(seconds<10)
            seconds = "0"+seconds;

        // Display the result in the element with id="demo"
        document.getElementById("counter").innerHTML = hours + ":"
        + minutes + ":" + seconds;

        // If the count down is finished, write some text
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("form").submit();
        }
        }, 1000);
    </script>
</x-guest-layout>
