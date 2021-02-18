@props(['type'])

<div class="m-6">
@php if($type=='success'){ @endphp
        <div class="w-full inline-flex items-center bg-white leading-none text-green-600 rounded-full p-2 shadow text-teal text-sm">
            <span class="inline-flex bg-green-600 text-white rounded-full h-6 px-3 justify-center items-center">Success</span>
@php }elseif($type=='warning'){ @endphp
        <div class="w-full inline-flex items-center bg-white leading-none text-yellow-600 rounded-full p-2 shadow text-teal text-sm">
            <span class="inline-flex bg-yellow-600 text-white rounded-full h-6 px-3 justify-center items-center">Warning</span>            
@php }else{ @endphp
        <div class="w-full inline-flex items-center bg-white leading-none text-blue-500 rounded-full p-2 shadow text-teal text-sm">
            <span class="inline-flex bg-blue-500 text-white rounded-full h-6 px-3 justify-center items-center">Info</span>
@php } @endphp
            <span class="inline-flex px-2">{{ $slot }}</span>
        </div>
    </div>
