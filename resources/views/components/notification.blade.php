@props(['message', 'isError' => false])

{{-- @if($message) 
    <script>
        $(window).on('load',function(){
            function notify(message){
                let type = `{{ $isError ? 'error' : 'success' }}`; 
                console.log('MESSAGE', message);
                console.log('TYPE', type);

                setTimeout(() => {
                    new Noty({
                        text: message,
                        type: 'success'
                    }).show();
                }, 500);
            }
            notify('{{ $message }}');
        });
    </script>
@endif --}}

@if ($message)
    @if ($isError)
        <div class="row notif-row fixed-top" style="margin-top: 65px; margin-right: 20px;">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <div class="alert alert-danger alert-icon-start alert-dismissible fade show">
                    <span class="alert-icon bg-danger text-white">
                        <i class="ph-x-circle"></i>
                    </span>
                    {{-- <span class="fw-semibold">Oh snap!</span> Change a few things up and <a href="#" class="alert-link">try submitting again</a>. --}}
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @else
        <div class="row notif-row fixed-top" style="margin-top: 65px; margin-right: 20px;">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <div class="alert alert-success alert-icon-start alert-dismissible fade show">
                    <span class="alert-icon bg-success text-white">
                        <i class="ph-check-circle"></i>
                    </span>
                    {{-- <span class="fw-semibold">Well done!</span> You successfully read <a href="#" class="alert-link">this important</a> alert message. --}}
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif
    <script>
        $('.notif-row').fadeOut(5000);
    </script>
@endif

