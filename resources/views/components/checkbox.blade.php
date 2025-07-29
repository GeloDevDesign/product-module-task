@props(['label' => '', 'fieldName' => '', 'checked' => true])

<div class="form-check form-switch">
    <input type="checkbox" class="form-check-input" name="{{ $fieldName }}" {{ $checked ? 'checked' : ''}} style="cursor:pointer;">
    <label class="form-check-label">{{ $label }}</label>
</div>