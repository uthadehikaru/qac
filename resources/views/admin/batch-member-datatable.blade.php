@extends('admin.datatable')
@section('action')
<form class="p-2 text-sm" method="post" 
        action="{{ route('admin.courses.batches.members.updates',['course'=>$batch->course_id,'batch'=>$batch->id]) }}"
        onsubmit="return validate();">
            @csrf
            <input type="checkbox" onClick="toggle(this)" class="mr-2" />
            <input type="hidden" id="members" name="members" value="" required />
            <label class="mr-2" id="selected_data">0 data terpilih</label>
            <select class="mr-2 rounded-md" id="status_id" name="status_id" required>
                <option value="0">- pilih status -</option>
                @foreach($statuses as $status)
                <option value="{{ $status }}">@lang('batch.status_'.$status)</option>
                @endforeach
            </select>
            <button class="border-full rounded-md bg-blue-500 p-2 text-white">Update</button>
        </form>
@endsection
@section('scripts')
<script type="text/javascript">
function toggle(source) {
  checkboxes = document.getElementsByName('ids');
  var count = 0;
  for(var i=0, n=checkboxes.length;i<n;i++) {
    if(source.checked)
        count++;
    checkboxes[i].checked = source.checked;
  }
  var selected = document.getElementById("selected_data");
    selected.innerHTML = count+" data terpilih";
}
function check(source) {
  checkboxes = document.getElementsByName('ids');
  var count = 0;
  for(var i=0, n=checkboxes.length;i<n;i++) {
    if(checkboxes[i].checked)
        count++;
  }
  var selected = document.getElementById("selected_data");
    selected.innerHTML = count+" data terpilih";
}
function validate() {
    var values = "";
    checkboxes = document.getElementsByName('ids');
    var count = 0;
    for(var i=0, n=checkboxes.length;i<n;i++) {
        if(checkboxes[i].checked){
            values += checkboxes[i].value+",";
            count++;
        }
    }
    if(count==0){
        alert('Tidak ada baris yang dipilih');
        return false;
    }
    
    var e = document.getElementById("status_id");
    var status_id = 0;
    if(e.selectedIndex>0)
        status_id = e.options[e.selectedIndex].value;
    if(status_id==0){
        alert('Pilih salah satu status');
        return false;
    }

    var members = document.getElementById("members");
    members.value = values;

    return true;
}
</script>
@endsection