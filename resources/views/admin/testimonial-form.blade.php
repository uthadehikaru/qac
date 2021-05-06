<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __($testimonial?'Edit':'New') }} {{ __('Testimonial') }}
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

        <form id="form" method="post" action="{{ route('admin.testimonials.'.($testimonial?'update':'store'), ($testimonial?$testimonial->id:null)) }}"
        enctype="multipart/form-data">
        @csrf

        @if($testimonial)
            <input name="_method" type="hidden" value="PUT">
        @endif
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-course_id">
                        @lang('Course')
                    </label>
                    <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-course_id" name="course_id" required>
                        <option value="">Pilih Kelas</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-batch_id">
                        @lang('Batch')
                    </label>
                    <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-batch_id" name="batch_id" required>
                    </select>
                </div>
                <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-member_id">
                        @lang('Peserta')
                    </label>
                    <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-member_id" name="member_id" required>
                    </select>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-testimonial">
                        @lang('Testimonial')
                    </label>
                    <textarea rows="10" class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-grey-lighter rounded py-3 px-4 mb-3" 
                    id="grid-testimonial" name="testimonial" placeholder="testimonial"
                    required>{{ old('testimonial', $testimonial?$testimonial->testimonial:'') }}</textarea>
                </div>
            </div>
        </div>
        </form>
    </x-panel>
    <x-slot name="scripts">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
        <script>
        jQuery(document).ready(function($){

            $('#grid-course_id').change(function($ev){
                var course_id = $(this).val();
                if(course_id>0){
                    $('#grid-batch_id').html("");
                    $.ajax({
                        url: "{{ url('api/batches') }}/"+course_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#grid-batch_id').html("<option value=''>Pilih Batch</option>");
                            jQuery.each(data, function(index, item) {
                                $('#grid-batch_id').append("<option value='"+index+"'>Batch "+item+"</option>");
                            });
                        }
                    });
                }
            });

            $('#grid-batch_id').change(function($ev){
                var batch_id = $(this).val();
                if(batch_id>0){
                    $('#grid-member_id').html("");
                    $.ajax({
                        url: "{{ url('api/members') }}/"+batch_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#grid-member_id').html("<option value=''>Pilih Member</option>");
                            jQuery.each(data, function(index, item) {
                                $('#grid-member_id').append("<option value='"+index+"'>"+item+"</option>");
                            });
                        }
                    });
                }
            });
            
        });
        </script>
    </x-slot>
</x-app-layout>