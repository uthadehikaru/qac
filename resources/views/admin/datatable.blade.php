<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight inline">
            {!! $title !!}
        </h2>
            @if(isset($button))
                {!! $button !!}
            @endif
            @if(isset($buttons))
                @foreach($buttons as $button)
                    <x-link-button class="float-right ml-2" href="{{ $button['href'] }}">{{ $button['name'] }}</x-link-button>
                @endforeach
            @endif
    </x-slot>
    
    @if(session('message'))
        <x-alert type="success">{{ session('message') }}</x-alert>
    @endif
    
    @if(session('error'))
        <x-alert type="error">{{ session('error') }}</x-alert>
    @endif

    <x-panel>
        @if(session('status'))
            <x-alert type="info">{{ session('status') }}</x-alert>
        @endif

        @hasSection('action')
            @yield('action')
        @endif
        {!! $dataTable->table(['class' => 'cell-border stripe'], true) !!}
    </x-panel>

<x-slot name="styles">
<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
	 <link href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
</x-slot>

<x-slot name="scripts">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script src="/vendor/datatables/buttons.server-side.js"></script>
{!! $dataTable->scripts() !!}
<script type="text/javascript">
    $(document).on('click', '.delete', function (e) {
        e.preventDefault();

        if(confirm("Delete this record?")) {
            var id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");
        
            $.ajax(
            {
                url: "{{ url()->current() }}/"+id,
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
@hasSection('scripts')
    @yield('scripts')
@endif
</x-slot>
</x-app-layout>