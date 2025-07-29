@props(['disabled' => false, 'label' => '', 'required' => false, 'error' => '', 'multiple' => false, 'validation' => false, 'nulled' => false, 'tooltip' => '', 'selectPlaceholder' => '', 'showRequiredLabel' => false ])

@php
    $classes = 'form-control select';    
    $labelMultiple = $multiple ? '<i>(can select multiple)</i>' : '';
    // if ($error) {
    //     $classes .= ' form-control-danger';
    // }
    if ($multiple) {
      $classes .= ' select2-multiple';
    }
@endphp

{{-- <div class="form-group form-default mb-5"> --}}
<div class="form-group form-default" style="margin-top: 0.25rem;">
   <div>
      @if ($tooltip) 
         <span  data-toggle="tooltip" data-placement="right" title="{{ $tooltip }}" style = "cursor: pointer;">
            <span class="" style="font-size: 11px;">{{ $label }} {!! $required ? '<span class="text-danger">*</span> '.$labelMultiple : '' !!}</span>
         </span>
      @else
         @if( $label )
            <span class="form-bar"></span>
         
            <label class="float-label mb-1">
               {{ $label }} {!! $required || $showRequiredLabel ? '<span class="text-danger">*</span> '.$labelMultiple : '' !!}
            </label>

         @endif
      @endif
      <select {!! $attributes->merge(['class' => $classes]) !!} {{ $disabled ? 'disabled' : '' }} 
         {{ $multiple ? 'multiple' : '' }}>

         @if( !$multiple )
            <option value="" selected {{ !$nulled ? 'disabled' : ''}}> {{ $selectPlaceholder != null ? $selectPlaceholder : '-- Select --' }}</option>
         @endif
         
            {{ $slot }}
      </select>
   </div>

   @if($required && $validation)
      <span class="error-text text-danger" x-show="error">This field is required.</span>
   @endif

   @if ($error)
      <span class="text-danger danger-error-msg">{{ $error }}</span>
   @endif
</div> 

@section('componentScripts')
<script src="{{ asset('limitless/js/vendor/forms/selects/select2.min.js') }}"></script>
<script>
    $('.select').select2();
</script>
    
@endsection