@props([
    'paginator',
    'onEachSide' => 2
])

@if ($paginator->hasPages())
    <nav class="pagination-container" role="navigation" aria-label="Pagination Navigation">
        <div class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-btn disabled" aria-disabled="true" aria-label="Previous">
                    <i class="fas fa-chevron-left"></i>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn" rel="prev" aria-label="Previous">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif

            {{-- Page Numbers --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="pagination-dots" aria-disabled="true">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-btn active" aria-current="page">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn" rel="next" aria-label="Next">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <span class="pagination-btn disabled" aria-disabled="true" aria-label="Next">
                    <i class="fas fa-chevron-right"></i>
                </span>
            @endif
        </div>

        {{-- Pagination Info --}}
        <div class="pagination-info">
            <p>
                Showing
                <span>{{ $paginator->firstItem() }}</span>
                to
                <span>{{ $paginator->lastItem() }}</span>
                of
                <span>{{ $paginator->total() }}</span>
                results
            </p>
        </div>
    </nav>
@endif

<style>
.pagination-container {
    margin: 50px 0;
    text-align: center;
}

.pagination {
    display: inline-flex;
    align-items: center;
    background: white;
    border-radius: 50px;
    padding: 5px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
}

.pagination-btn {
    min-width: 40px;
    height: 40px;
    margin: 0 2px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    color: #666;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.pagination-btn:hover:not(.disabled):not(.active) {
    background: #f8f8f8;
    color: #ff2200;
}

.pagination-btn.active {
    background: #ff2200;
    color: white;
}

.pagination-btn.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.pagination-dots {
    padding: 0 10px;
    color: #999;
}

.pagination-info {
    margin-top: 15px;
    color: #666;
    font-size: 14px;
}

.pagination-info span {
    color: #333;
    font-weight: 600;
}

/* Responsive Design */
@media (max-width: 480px) {
    .pagination {
        padding: 3px;
    }

    .pagination-btn {
        min-width: 35px;
        height: 35px;
        font-size: 14px;
    }
}
</style>