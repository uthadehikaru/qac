<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __($subscription?'Edit':'Add') }} {{ __('Subscriber') }}
        </h2>
        <div class="float-right">
            <x-link-button href="{{ route('admin.ecourses.subscriptions.index', $ecourse->id) }}" class=" ml-3" type="warning">Back</x-button>
        </div>
    </x-slot>

    <x-panel>
    
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form id="form" method="post" 
        @if($subscription)
        action="{{ route('admin.ecourses.subscriptions.update', [$ecourse->id, $subscription->id]) }}"
        @else
        action="{{ route('admin.ecourses.subscriptions.store', $ecourse->id) }}"
        @endif
        enctype="multipart/form-data">
            @csrf

            @if($subscription)
                <input name="_method" type="hidden" value="PUT">
            @endif
            <div class="px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <div class="-mx-3 md:flex mb-6">
                    <div class="md:w-2/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-member_id">
                            Member
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-member_id" name="member_id" required>
                            <option value="">-- Pilih Member --</option>
                            @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ $subscription && $subscription->member_id==$member->id?'selected':'' }}>{{ $member->full_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-start_date">
                            Start Date
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-start_date" name="start_date" type="date" placeholder="member start_date" value="{{ old('start_date', $subscription?$subscription->start_date:'') }}" required>
                    </div>
                    <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-end_date">
                            End Date
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-end_date" name="end_date" type="date" placeholder="member end_date" value="{{ old('end_date', $subscription?$subscription->end_date:'') }}">
                    </div>
                </div>
                <button type="submit" class="p-4 border bg-blue-500 rounded text-white">Save</button>
            </div>
        </form>
        <hr />
        <form id="form" method="post" 
        action="{{ route('admin.ecourses.batch', $ecourse->id) }}">
            @csrf
            <div class="px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <h1 class="text-xl font-bold mt-2">or Add From Batch</h1>
                <p class="italic">hanya untuk anggota yang telah lunas pembayaran</p>
                <div class="-mx-3 md:flex mb-6 mt-2">
                    <div class="md:w-2/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-batch_id">
                            Batch
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-batch_id" name="batch_id" required>
                            <option value="">-- Pilih Batch --</option>
                            @foreach($batches as $batch)
                            <option value="{{ $batch->id }}">{{ $batch->course->name.' - batch '.$batch->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-start_date">
                            Start Date
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-start_date" name="start_date" type="date" placeholder="member start_date" value="{{ old('start_date', $subscription?$subscription->start_date:'') }}" required>
                    </div>
                    <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-end_date">
                            End Date
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-end_date" name="end_date" type="date" placeholder="member end_date" value="{{ old('end_date', $subscription?$subscription->end_date:'') }}">
                    </div>
                </div>
                <button type="submit" class="p-4 border bg-blue-500 rounded text-white">Save</button>
            </div>
        </form><hr />
        <form id="form" method="post" 
        action="{{ route('admin.ecourses.course', $ecourse->id) }}">
            @csrf
            <div class="px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
                <h1 class="text-xl font-bold mt-2">or Add From Course</h1>
                <p class="italic">hanya untuk anggota yang telah lunas pembayaran</p>
                <div class="-mx-3 md:flex mb-6 mt-2">
                    <div class="md:w-2/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-course_id">
                            Course
                        </label>
                        <select class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-course_id" name="course_id" required>
                            <option value="">-- Pilih Course --</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-start_date">
                            Start Date
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-start_date" name="start_date" type="date" placeholder="member start_date" value="{{ old('start_date', $subscription?$subscription->start_date:'') }}" required>
                    </div>
                    <div class="md:w-1/4 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-end_date">
                            End Date
                        </label>
                        <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                        id="grid-end_date" name="end_date" type="date" placeholder="member end_date" value="{{ old('end_date', $subscription?$subscription->end_date:'') }}">
                    </div>
                </div>
                <button type="submit" class="p-4 border bg-blue-500 rounded text-white">Save</button>
            </div>
        </form>
    </x-panel>
</x-app-layout>