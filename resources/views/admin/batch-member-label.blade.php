<x-guest-layout>
<div class="grid grid-cols-2">
    @foreach($batch->members as $member)
    <div class="p-2 text-center border border-black">
    <p class="font-bold">{{ $member->full_name }}</p>
    <p class="my-2">{{ $member->address }}</p>
    <p>{{ $member->phone }}</p>
    </div>
    @endforeach
</div>
<x-slot name="scripts">
<script>
window.print();
</script>
</x-slot>
</x-guest-layout>