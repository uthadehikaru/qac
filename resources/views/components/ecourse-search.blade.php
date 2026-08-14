@props(['action', 'search' => '', 'category' => null])

<form action="{{ $action }}" method="GET" class="mb-4 px-4 md:w-1/2 md:mx-auto md:px-0">
    <div class="flex gap-2 min-w-0">
        @if($category)
            <input type="hidden" name="category" value="{{ $category }}">
        @endif
        <input
            type="search"
            name="search"
            value="{{ $search }}"
            placeholder="Cari video..."
            class="flex-1 min-w-0 px-4 py-2 text-xs md:text-sm border border-yellow-500 rounded-full focus:outline-none focus:ring-2 focus:ring-yellow-500"
        >
        <button type="submit" class="shrink-0 px-4 py-2 text-xs md:text-sm bg-yellow-500 text-white rounded-full hover:bg-yellow-600 whitespace-nowrap">
            Cari
        </button>
    </div>
</form>
