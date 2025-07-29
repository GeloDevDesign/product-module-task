@props(['model' => null, 'action' => '', 'heading' => '', 'returnUrl' => '', 'noActive' => false])

<form method="POST" class="form-material" action="{{ $action }}" enctype="multipart/form-data">
    @csrf
    @if(optional($model)->exists)
        @method('PUT')
    @endif

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="mT-30">
                {{ $slot }}
            </div>
        </div>

        <div class="text-center mt-4">
            <x-button type="button" onclick="window.location.href='{{ $returnUrl }}'" class="btn-danger btn-block pull-right me-2" :action="'back'">Cancel</x-button>
            <x-button type="submit" class="btn-success btn-block pull-right">{{ $buttonText ?? 'Save'}}</x-button>
        </div>
    </div>
</form>