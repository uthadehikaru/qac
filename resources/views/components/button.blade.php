<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-[#7b0c00] text-white font-bold rounded-lg my-6 py-2 px-4 text-sm']) }}>
    {{ $slot }}
</button>
