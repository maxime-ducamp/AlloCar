@if ($paginator->hasPages())
    <ul class="flex justify-between items-center mt-10 list-reset mx-auto w-full md:w-1/2" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled flex-1 no-underline text-center" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="link text-blue-light cursor-not-allowed" aria-hidden="true"><</span>
            </li>
        @else
            <li class="flex-1 text-center">
                <a class="link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')"><</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="disabled flex-1 text-center" aria-disabled="true"><span class="link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="cursor-pointer flex-1 text-center text-2xl" aria-current="page"><span class="link">{{ $page }}</span></li>
                    @else
                        <li class="text-blue-light flex-1 no-underline flex-1 cursor-pointer text-center"><a class="link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="flex-1 text-center">
                <a class="link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">></a>
            </li>
        @else
            <li class="page-item disabled flex-1 text-center cursor-not-allowed" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="link text-blue-light cursor-not-allowed" aria-hidden="true">></span>
            </li>
        @endif
    </ul>
@endif
