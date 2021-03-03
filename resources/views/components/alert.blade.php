@props(['type','title'])

@php 
$color = 'gray';
if($type=='success')
    $color = 'green';
elseif($type=='error')
    $color = 'red';
elseif($type=='warning')
    $color = 'yellow';
elseif($type=='info')
    $color = 'blue';
else
    $color = 'gray';
@endphp

<div class="m-6">
    <div class="w-full inline-flex items-center bg-white leading-none text-{{ $color }}-500 rounded-full p-2 shadow text-sm">
        <span class="inline-flex bg-{{ $color }}-500 text-white rounded-full h-6 px-3 justify-center items-center">{{ $title ?? $type }}</span>
        <span class="inline-flex px-2">{{ $slot }}</span>
    </div>
</div>
