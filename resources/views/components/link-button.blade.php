@props(['type'])

@php 
$color = 'blue';
if(!isset($type))
    $type = '';

if($type=='success')
    $color = 'green';
elseif($type=='error')
    $color = 'red';
elseif($type=='warning')
    $color = 'yellow';
@endphp

<a {{ $attributes->merge(['class' => 'inline-flex items-center px-4 py-2 bg-'.$color.'-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</a>
