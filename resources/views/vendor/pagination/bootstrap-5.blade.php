@if ($paginator->hasPages() && $paginator->lastPage() > 1)
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-secondary">
            {{-- First Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link"><i class="tf-icon bx bx-chevrons-left"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url(1) }}" aria-label="First">
                        <i class="tf-icon bx bx-chevrons-left"></i>
                    </a>
                </li>
            @endif

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link"><i class="tf-icon bx bx-chevron-left"></i></span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        <i class="tf-icon bx bx-chevron-left"></i>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled">
                        <span class="page-link">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page">
                                <span class="page-link">{{ $page }}</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        <i class="tf-icon bx bx-chevron-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link"><i class="tf-icon bx bx-chevron-right"></i></span>
                </li>
            @endif

            {{-- Last Page Link --}}
            @if (!$paginator->onLastPage())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" aria-label="Last">
                        <i class="tf-icon bx bx-chevrons-right"></i>
                    </a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link"><i class="tf-icon bx bx-chevrons-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@else
    {{-- Display default design for single page --}}
    <nav aria-label="Page navigation">
        <ul class="pagination pagination-secondary">
            <li class="page-item disabled">
                <span class="page-link">No Pages</span>
            </li>
        </ul>
    </nav>
@endif
