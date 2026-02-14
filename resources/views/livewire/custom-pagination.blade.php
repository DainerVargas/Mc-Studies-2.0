@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="custom-pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="pagination-btn disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <span class="material-symbols-outlined">chevron_left</span>
            </span>
        @else
            <button type="button" wire:click="previousPage" rel="prev" class="pagination-btn"
                aria-label="@lang('pagination.previous')">
                <span class="material-symbols-outlined">chevron_left</span>
            </button>
        @endif

        {{-- Pagination Elements --}}
        <div class="pagination-numbers">
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="pagination-dots" aria-disabled="true">{{ $element }}</span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-number active" aria-current="page">{{ $page }}</span>
                        @else
                            <button type="button" wire:click="gotoPage({{ $page }})" class="pagination-number"
                                aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                {{ $page }}
                            </button>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <button type="button" wire:click="nextPage" rel="next" class="pagination-btn"
                aria-label="@lang('pagination.next')">
                <span class="material-symbols-outlined">chevron_right</span>
            </button>
        @else
            <span class="pagination-btn disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <span class="material-symbols-outlined">chevron_right</span>
            </span>
        @endif
    </nav>
@endif
