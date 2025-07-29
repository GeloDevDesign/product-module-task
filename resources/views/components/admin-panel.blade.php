@props([
    'heading' => null, 
    'entityId' => null, 
    'deleteRoute' => null, 
    'deleteMsg' => null, 
    'collapsible' => false, 
    'defaultHidden' => false,

    'hasPerPage' => false,
    'perPageRoute' => null,
    'filters' => []
])

 <div class="card filter-block">
    @if ($heading)
        <div class="card-header d-flex justify-content-between {{ $collapsible ? 'minimize-section' : ''}}" >
            <h5>{{ $heading }}</h5>

            @if ($collapsible)
                <div class="card-header-right">
                    <ul class="list-unstyled card-option">
                        <li><i class="fa {{ $defaultHidden ? 'fa-plus' : 'fa-minus' }} minimize-card"></i></li>
                    </ul>
                </div>
            @endif

            @if($deleteRoute != null)
              <span data-toggle="modal" data-target="#deleteConfirm-{{ $entityId }}"><i class="fa fa open-card-option fa-times" ></i></span>
              {{-- <button type="button" title="Delete" class="btn btn-danger btn-sm waves-effect waves-light" data-toggle="modal" data-target="#deleteConfirm-{{ $entityId }}">
                  <i class="fa fa-trash" aria-hidden="true"></i>
              </button> --}}
              <x-delete-confirm-modal :action="$deleteRoute" :entity-id="$entityId">
                  <div class="mt-2">
                      <p class="text-sm text-gray-500">
                      @if ( $deleteMsg )
                          {{ $deleteMsg }}
                      @else
                          Are you sure you want to delete <u>{{ $heading }}</u>?
                      @endif
                      </p>
                  </div>
              </x-delete-confirm-modal>
            @endif

        </div>
    @endif
    <div class="card-body" style="{{ $defaultHidden ? 'display: none' : ''}}">
        @if ($hasPerPage)

        <form action="{{ $perPageRoute }}" method="get" id="perPageForm">
            <div class="row mb-3">

                @php
                    unset($filters['per_page'])
                @endphp
                @foreach ($filters as $key => $val)
                <input type="hidden" name="{{ $key }}" value="{{ $val ?? '' }}">                    
                @endforeach

                <div class="col-md-10">
                    <label for="" style="float: right; margin-top: 12px;">
                        Display per page
                    </label>
                </div>
                <div class="col-md-2">
                    <div class="input-group mt-1">
                        <span class="input-group-text">
                            <i class="ph-user-circle"></i>
                        </span>
                        <select class="form-select" name="per_page" id="per_page">
                            {{-- <option value="2" {{ request()->per_page == '2' ? 'selected' : '' }}>2</option> --}}
                            <option value="10" {{ request()->per_page == '10' ? 'selected' : '' }}>10</option>
                            <option value="25" {{ request()->per_page == '25' ? 'selected' : '' }}>25</option>
                            <option value="50" {{ request()->per_page == '50' || !request()->per_page ? 'selected' : '' }}>50</option>
                            <option value="100" {{ request()->per_page == '100' ? 'selected' : '' }}>100</option>
                            <option value="all" {{ request()->per_page == 'all' ? 'selected' : '' }}>All</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
        @endif
        {{ $slot }}
    </div>
</div>

@section('adminPanelScripts')
<script>
$('#per_page').on('change', function() {
        console.log('per page change')
        $('#perPageForm').submit();
    })
</script>
@endsection