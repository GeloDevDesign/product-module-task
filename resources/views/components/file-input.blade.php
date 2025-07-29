@props(['disabled' => false, 'error' => null, 'formtext' => '', 'accept' => ''])

@php
    $classes = 'form-control';

    if ($error) {
        $classes .= ' is-invalid';
    }
@endphp

<div class="input-group">
    <input type="file" {!! $attributes->merge(['class' => $classes]) !!} accept="{{ $accept ? $accept : '.doc,.docx,application/pdf' }}" {{ $disabled ? 'disabled' : '' }}>
</div>

<div class="form-text">{{ $formtext }}</div>
