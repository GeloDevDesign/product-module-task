@props(['disabled' => false, 'error' => null, 'icon' => null])

@php
    $classes = 'form-control datepicker-basic';

    if ($error) {
        $classes .= ' is-invalid';
    }
@endphp

@if (!$icon)
<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $classes]) !!}>
@else
<div class="input-group">
    {{-- for icons, refer to Phosphor icons https://demo.interface.club/limitless/demo/template/html/layout_1/full/icons_phosphor.html --}}

    {{-- <span class="input-group-text"><i class="ph-user-circle"></i></span> --}}
    <span class="mt-1 input-group-text"><i class="{{ $icon }}"></i></span>
    <input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => $classes]) !!}>
    {{-- <button class="btn btn-light mt-1 " type="button"><i class="fas fa-eye-slash"></i></button> --}}
</div>
@endif

@section('componentScripts')
<script src="{{ asset('limitless/js/vendor/pickers/daterangepicker.js') }}"></script>
<script src="{{ asset('limitless/js/vendor/pickers/datepicker.min.js') }}"></script>
<script>
    if (typeof Datepicker == 'undefined') {
        console.warn('Warning - datepicker.min.js is not loaded.');
    }

    // Basic example
    const dpBasicElement = document.querySelector('.datepicker-basic');
    if(dpBasicElement) {
        const dpBasic = new Datepicker(dpBasicElement, {
            container: '.content-inner',
            buttonClass: 'btn',
            prevArrow: document.dir == 'rtl' ? '&rarr;' : '&larr;',
            nextArrow: document.dir == 'rtl' ? '&larr;' : '&rarr;'
        });
    }
</script>
@endsection
