@props(['disabled' => false, 'error' => null, 'icon' => null])

@php
    $classes = 'form-control';

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
