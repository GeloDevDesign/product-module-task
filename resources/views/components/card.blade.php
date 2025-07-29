@props(['heading' => null])

<div class="card card-collapsed">
    @if($heading !== null)
        <div class="card-header d-flex flex-wrap">
            <h6 class="mb-0">{{$heading}}</h6>
            {{-- <div class="d-inline-flex ms-auto">
                <a class="text-body" data-card-action="collapse">
                    <i class="ph-caret-down"></i>
                </a>
            </div> --}}
        </div>
    @endif
    {{-- <div class="collapse show" style=""> --}}
        <div class="card-body">
            {{$slot}}
        {{-- </div> --}}
    </div>
</div>