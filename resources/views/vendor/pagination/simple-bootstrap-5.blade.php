@if ($paginator->hasPages())
    <nav aria-label="Page navigation">
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}">Previous</a>
                </li>
            @endif

            @for ($page = 1; $page <= $paginator->lastPage(); $page++)
                <li class="page-item {{ $page == $paginator->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                </li>
            @endfor

            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}">Next</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
