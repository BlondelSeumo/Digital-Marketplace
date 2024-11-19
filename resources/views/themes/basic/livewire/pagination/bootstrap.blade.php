<div>
    @if ($paginator->hasPages())
        <div class="mt-4">
            @php(isset($this->numberOfPaginatorsRendered[$paginator->getPageName()]) ? $this->numberOfPaginatorsRendered[$paginator->getPageName()]++ : ($this->numberOfPaginatorsRendered[$paginator->getPageName()] = 1))
            <nav>
                <ul class="pagination">
                    @if ($paginator->onFirstPage())
                        <li class="page-item disabled" aria-disabled="true" aria-label="@translate('pagination.previous')">
                            <span class="page-link" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                        </li>
                    @else
                        <li class="page-item">
                            <button type="button"
                                dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                class="page-link" wire:click="previousPage('{{ $paginator->getPageName() }}')"
                                wire:loading.attr="disabled" rel="prev" aria-label="@translate('pagination.previous')"><i
                                    class="fas fa-chevron-left"></i></button>
                        </li>
                    @endif
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li class="page-item disabled" aria-disabled="true"><span
                                    class="page-link">{{ $element }}</span></li>
                        @endif
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li class="page-item active"
                                        wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page-{{ $page }}"
                                        aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"
                                        wire:key="paginator-{{ $paginator->getPageName() }}-{{ $this->numberOfPaginatorsRendered[$paginator->getPageName()] }}-page-{{ $page }}">
                                        <button type="button" class="page-link"
                                            wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')">{{ $page }}</button>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    @if ($paginator->hasMorePages())
                        <li class="page-item">
                            <button type="button"
                                dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                                class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')"
                                wire:loading.attr="disabled" rel="next" aria-label="@translate('pagination.next')"><i
                                    class="fas fa-chevron-right"></i></button>
                        </li>
                    @else
                        <li class="page-item disabled" aria-disabled="true" aria-label="@translate('pagination.next')">
                            <span class="page-link" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    @endif
</div>
