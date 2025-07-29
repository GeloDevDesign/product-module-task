@props(['collection' => [], 'filters' => null])

@php
    $queryStrings = $filters ?? request()->all();

    $showPagination = !isset($queryStrings['per_page']) || (isset($queryStrings['per_page']) && $queryStrings['per_page'] != 'all');

    // dd(empty(array_filter($queryStrings, fn ($item) => !is_null($item))));
@endphp
<div class="mt-3">
    @if ($showPagination)
    {{ $collection->withQueryString($queryStrings)->links() }}
    @endif
</div>