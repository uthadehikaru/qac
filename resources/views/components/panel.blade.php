<div {{ $attributes->merge(['class' => 'py-4 md:py-12']) }}>
    <div class="max-w-12xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 md:p-6 bg-white border-b border-gray-200">
            {{ $slot }}
            </div>
        </div>
    </div>
</div>