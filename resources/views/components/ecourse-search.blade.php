@props(['action', 'search' => '', 'category' => null])

<form action="{{ $action }}" method="GET" class="mx-4 mb-4 w-full md:w-1/2 md:mx-auto">
    <div class="flex gap-2">
        @if($category)
            <input type="hidden" name="category" value="{{ $category }}">
        @endif
        <input
            type="search"
            name="search"
            value="{{ $search }}"
            placeholder="Cari video..."
            class="flex-1 px-4 py-2 text-xs md:text-sm border border-yellow-500 rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500"
        >
        <button type="submit" class="px-4 py-2 text-xs md:text-sm bg-yellow-500 text-white rounded-full hover:bg-yellow-600 whitespace-nowrap">
            Cari
        </button>
    </div>
</form>
