@props([
  'model' => null, 
  'action' => '', 
  'heading' => '', 
  'returnUrl' => '', 
  'noActive' => false, 
  'checkbox' => null, 
  'noButtons' => false,
  'checkboxName' => '', 
  'uploadForm' => false,
  'customButtons' => null
])

<form method="GET" class="form-material" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if(!is_null($model) && $model->exists)
    @method('PATCH')
    @endif

    <div class="row">
        @php
            $colMd = !$noButtons ? 'col-md-9' : 'col-md-12';
        @endphp
        <div class="{{ $colMd }}">
            <div class="mT-30">
                <x-admin-panel :heading="$heading">
                    {{ $slot }}
                </x-admin-panel>
            </div>
        </div>
        
        @if (!$noButtons)
          <div class="col-md-3">
              <div class="card">
                  <div class="card-header">
                      <h5>Actions</h5>
                  </div>
                  <div class="card-block" >
                    @if($checkbox)
                      @php
                        $check = ($model && $model->$checkbox) ? true : false;
                      @endphp
                      <x-checkbox :fieldName="$checkbox" :label="$checkboxName" :checked="$check" ></x-checkbox>
                      @if( $noActive )
                        <hr>
                      @endif
                    @endif

                    @if (!$noActive)
                      <div class="checkbox-fade fade-in-primary d-" id="active-wrap">
                          <label>
                              <input type="checkbox" id="active" name="active" {{ (!is_null($model) && !$model->exists) || (!is_null($model) && $model->active) ? 'checked' : '' }} >
                              <span class="cr"><i class="cr-icon icofont icofont-ui-check txt-primary"></i></span>
                              <span class="text-inverse">Active</span>
                          </label>
                      </div>
                    <hr>
                    @endif

                    @if($returnUrl)
                      <x-button type="button" onclick="window.location.href='{{ $returnUrl }}'" class="btn-danger btn-block pull-right" :action="'back'">Cancel</x-button>
                    @endif
                    <x-button type="submit" class="btn-success btn-block pull-right" :action="'add'">Save</x-button>

                    {{ $customButtons }}
                  </div>
              </div>
          </div>
        @endif
    </div>
</form>