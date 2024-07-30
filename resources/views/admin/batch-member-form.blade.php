<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
        {{ __($batch?'Edit':'Buat') }} Anggota
        - <a href="{{ route('admin.courses.batches.members', [$batch->course->id, $batch->id]) }}" class="pointer text-blue-500">@lang('Batch') {{ $batch->full_name }}</a>
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

        <form id="form" method="post" 
        @if($batchMember)
        action="{{ route('admin.courses.batches.members.update', [$batch->course_id, $batch->id, $batchMember->id]) }}"
        @else
        action="{{ route('admin.courses.batches.members.create', [$batch->course_id, $batch->id]) }}"
        @endif
        enctype="multipart/form-data">
        @csrf

        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 flex flex-col my-2">
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-member_id">
                        Member
                    </label>
                    @if($batchMember)
                    <input id="grid-member_id" name="member_id" disabled value="{{ $batchMember->member->full_name }}"
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3"/>
                    @else
                    <select id="grid-member_id" name="member_id" required
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3">
                        <option value="">-- choose member --</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                        @endforeach
                    </select>
                    @endif
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-session">
                        Session
                    </label>
                    <select id="grid-session" name="session"
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3">
                        <option value="">-- choose session --</option>
                        @foreach($sessions as $session)
                            <option value="{{ $session }}" {{ $batchMember && $batchMember->session==$session?'selected':'' }}>{{ $session }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-status">
                        Status
                    </label>
                    <select id="grid-status" name="status"
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ $batchMember && $batchMember->status==$status?'selected':'' }}>@lang('batch.status_'.$status)</option>
                        @endforeach
                    </select>
                </div>
                <div class="md:w-1/3 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-status">
                        Reseat
                    </label>
                    <select id="grid-reseat" name="reseat"
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3">
                        <option value="1" {{ $batchMember && $batchMember->reseat==1?'selected':'' }}>Ya</option>
                        <option value="0" {{ $batchMember && $batchMember->reseat==0?'selected':'' }}>Tidak</option>
                    </select>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-note">
                        Note
                    </label>
                    <textarea class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-note" name="note">{{ $batchMember?$batchMember->note:'' }}</textarea>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-full px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-testimonial">
                        Testimoni
                    </label>
                    <textarea class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-testimonial" name="testimonial">{{ $batchMember?$batchMember->testimonial:'' }}</textarea>
                </div>
            </div>
            <div class="-mx-3 md:flex mb-6">
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-filename">
                        Sertifikat
                    </label>
                    <input class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3" 
                    id="grid-filename" name="filename" type="file">
                </div>
                @if($batchMember && $batchMember->file)
                <div class="md:w-1/2 px-3 mb-6 md:mb-0">
                    <label class="block uppercase tracking-wide text-grey-darker text-xs font-bold mb-2" for="grid-filename">
                        unduh
                    </label>
                    <a href="{{ $batchMember->file->fileUrl('filename') }}" target="_blank"
                    class="appearance-none block w-full bg-grey-lighter text-grey-darker border border-red rounded py-3 px-4 mb-3">
                    {{ $batchMember->file->name }}
                    </a>
                </div>
                @endif
            </div>
        </div>
        </form>
    </x-panel>
</x-app-layout>