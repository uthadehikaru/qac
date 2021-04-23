<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            Data {{ __('Events') }}
        </h2>
        <x-link-button href="{{ route('admin.events.create') }}" class="float-right">New @lang('Events')</x-button>
    </x-slot>

    <x-panel>
        <table class="table-auto datatable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Views</th>
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
        "scrollX":true,
        serverSide: true,
        ajax: "{{ route('admin.events.index') }}",
        columns: [
            {data: 'event_at', name: 'event_at'},
            {data: 'title', name: 'title'},
            {data: 'is_public', name: 'is_public'},
            {data: 'views', name: 'views'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    
  });

    $(document).on('click', '.delete', function (e) {
        e.preventDefault();

        if(confirm("Delete this record?")) {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
        
            $.ajax(
            {
                url: "{{ route('admin.events.index') }}/"+id,
                type: 'DELETE',
                data: {
                    "id": id,
                    "_token": token,
                },
                success: function (data){
                    $('#delete-'+id).closest('tr').remove();
                    alert(data.status);
                }
            });
        }
    });
</script>
</x-slot>
</x-app-layout>