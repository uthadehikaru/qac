<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {{ __('Member') }} - {{ $member->name }}
        </h2>
        <div class="float-right">
        {{ $member->user->email }} | {{ $member->phone }}
        </div>
        <p class="">{{ $member->address }}</p>
    </x-slot>

    <x-panel>
        <table class="table-auto datatable">
            <thead>
                <tr>
                    <th>Batch</th>
                    <th>Approved Date</th>
                    <th width="100px">Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </x-panel>

<x-slot name="styles">
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
</x-slot>

<x-slot name="scripts">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript">
    $(function () {
        
        var table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('admin.members.show', $member->id) }}",
            columns: [
                {data: 'batch_id', name: 'batch_id'},
                {data: 'approved_at', name: 'approved_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
        
    });
</script>
</x-slot>
</x-app-layout>