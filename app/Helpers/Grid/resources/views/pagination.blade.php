<div class="row mt-2 d-flex justify-content-center">
  @if($paginator->total() > 0)
    <div class="dataTables_info">
      {{ $paginator->total() }}
      件中{{ $paginator->firstItem() }}～{{ $paginator->lastItem() }}件を表示
    </div>
  @endif
  @if ($paginator->hasPages())
    <div class="ml-2 dataTables_paginate paging_simple_numbers">
      <ul class="pagination">
        @if ($paginator->onFirstPage())
          <li class="page-item previous disabled">
              <span class="page-link disabled" role="button" tabindex="-1" aria-disabled="true">
                <i class="ti-angle-left"></i>
              </span>

          </li>
        @else
          <li class="page-item previous">
            <a class="page-link"
               data-page="{{ $paginator->currentPage() -1 }}"
               href="{{ $paginator->previousPageUrl() }}"><i class="ti-angle-left"></i></a>
          </li>
        @endif
        @foreach ($elements as $element)
          {{-- "Three Dots" Separator --}}
          @if (is_string($element))
            <li class="page-item disabled" aria-disabled="true">
              <a class="page-link">{{ $element }}</a>
            </li>
          @endif

          {{-- Array Of Links --}}
          @if (is_array($element))
            @foreach ($element as $page => $url)
              @if ($page == $paginator->currentPage())
                <li class="page-item active" aria-current="page">
                  <a class="page-link disabled" tabindex="-1" aria-disabled="true"
                     data-page="{{ $page}}">
                    {{ $page }}</a>
                </li>
              @else
                <li class="page-item">
                  <a href="{{ $url }}" data-page="{{ $page}}" class="page-link">{{ $page }}</a>
                </li>
              @endif
            @endforeach
          @endif
        @endforeach
        @if ($paginator->hasMorePages())
          <li class="paginate_button page-item next">
            <a class="page-link"
               data-page="{{ $paginator->currentPage() + 1 }}"
               href="{{ $paginator->nextPageUrl() }}">
              <i class="ti-angle-right"></i>
            </a>
          </li>
        @else
          <li class="paginate_button page-item next disabled">
            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
              <i class="ti-angle-right"></i>
            </a>
          </li>
        @endif
      </ul>
    </div>
  @endif
</div>
