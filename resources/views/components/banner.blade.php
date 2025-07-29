@props(['currentPage' => 'Current Page'])

<!-- Page banner -->
<div class="page-header page-header-light shadow">
    <div class="page-header-content d-lg-flex border-top">
        <div class="d-flex">
            <div class="breadcrumb py-2">
                <a href="{{route('admin.index')}}" class="breadcrumb-item"><i class="ph-house"></i></a>
                <span class="breadcrumb-item active">{{$currentPage}}</span>
            </div>
        </div>
    </div>
</div>
<!-- /page banner -->