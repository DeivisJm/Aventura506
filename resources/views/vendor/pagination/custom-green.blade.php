@if ($paginator->hasPages())
<nav class="flex items-center gap-2">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
    <span class="px-3 py-2 rounded-lg border text-gray-400 cursor-not-allowed">
        ‹
    </span>
    @else
    <a href="{{ $paginator->previousPageUrl() }}"
        class="px-3 py-2 rounded-lg border hover:bg-green-100 transition">
        ‹
    </a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)

    @if (is_string($element))
    <span class="px-3 py-2">{{ $element }}</span>
    @endif

    @if (is_array($element))
    @foreach ($element as $page => $url)

    @if ($page == $paginator->currentPage())
    <span class="px-4 py-2 rounded-lg bg-green-600 text-white shadow">
        {{ $page }}
    </span>
    @else
    <a href="{{ $url }}"
        class="px-4 py-2 rounded-lg border hover:bg-green-100 transition">
        {{ $page }}
    </a>
    @endif

    @endforeach
    @endif

    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}"
        class="px-3 py-2 rounded-lg border hover:bg-green-100 transition">
        ›
    </a>
    @else
    <span class="px-3 py-2 rounded-lg border text-gray-400 cursor-not-allowed">
        ›
    </span>
    @endif

</nav>
@endif