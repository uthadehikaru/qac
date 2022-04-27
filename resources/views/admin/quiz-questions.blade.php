<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            <a href="{{ route('admin.quiz.index') }}" class="pointer text-blue-500">{{ __('Quizzes') }}</a> - {{ $quiz->name }}
        </h2>
        <div class="float-right">
            <x-link-button  href="javascript:void(0)" onclick="document.getElementById('form').submit();" id="save" class=" ml-3">Simpan</x-button>
        </div>
    </x-slot>

    <x-panel>
    
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form id="form" method="post" action="{{ route('admin.quiz.questions', $quiz->id) }}"
        enctype="multipart/form-data">
        @csrf

        <div class="bg-gray-200 shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <x-input 
                type="hidden"
                name="question_id[]"
                value="0" />
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-3/4 px-3 mb-6 md:mb-0">
                    <x-label for="question">{{ __('New') }} {{ __('Question') }}</x-label>
                    <x-input id="question" class="block mt-1 w-full"
                                    type="text"
                                    name="question[]"
                                    required />
                </div>
                <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                    <x-label for="answer">{{ __('Correct Answer') }}</x-label>
                    <x-select id="answer" class="block mt-1 w-full"
                                    name="answer[]"
                                    required>
                        @foreach($options as $option)
                        <option value="{{ $option }}">{{ $option }}</option>
                        @endforeach
                    </x-select>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                @foreach($options as $option)
                <div class="md:w-1/{{ count($options) }} px-3 mb-6 md:mb-0">
                    <x-label for="option_{{ $option }}">{{ __('Option') }} {{ $option }}</x-label>
                    <x-input id="option_{{ $option }}" class="block mt-1 w-full"
                                    type="text"
                                    name="option_{{ $option }}[]"
                                    required />
                </div>
                @endforeach
            </div>
        </div>
        @foreach($quiz->questions as $question)
        <div class="bg-green-200 shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <x-input 
                type="hidden"
                name="question_id[]"
                value="{{ $question->id }}" 
                required />
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-3/4 px-3 mb-6 md:mb-0">
                    <x-label for="question_{{ $question->id }}">
                        {{ __('Question') }} {{ $i++ }}
                        <a href="{{ route('admin.quiz.questions.delete', [$quiz->id,$question->id]) }}" class="pointer text-red-500">( {{ __('Delete') }} )</a>
                    </x-label>
                    <x-input id="question_{{ $question->id }}" class="block mt-1 w-full"
                                    type="text"
                                    name="question[]"
                                    value="{{ $question->content }}"
                                    required />
                </div>
                <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                    <x-label for="answer_{{ $question->id }}">{{ __('Correct Answer') }}</x-label>
                    <x-select id="answer_{{ $question->id }}" class="block mt-1 w-full"
                                    name="answer[]"
                                    required>
                        @foreach($options as $option)
                        <option value="{{ $option }}" {{ $question->answer==$option?'selected':''}}>{{ $option }}</option>
                        @endforeach
                    </x-select>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                @foreach($options as $option)
                <div class="md:w-1/{{ count($options) }} px-3 mb-6 md:mb-0">
                    <x-label for="option_{{ $option }}_{{ $question->id }}">{{ __('Option') }} {{ $option }}</x-label>
                    <x-input id="option_{{ $option }}_{{ $question->id }}" class="block mt-1 w-full"
                                    type="text"
                                    name="option_{{ $option }}[]"
                                    value="{{ $question->getOriginal('option_'.$option) }}"
                                    required />
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
        </form>
    </x-panel>
</x-app-layout>