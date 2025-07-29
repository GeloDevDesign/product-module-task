@extends('layouts.app')

@section('banner')
   <x-banner :current-page="'Create User'" ></x-banner>
@endsection

@section('styles')
    <style>
        .file-thumbnail-footer {
            display: none;
        }
        .file-preview {
            width: 45% !important;
        }
    </style>
@endsection

@section('content')

    <x-card :heading="'User Form'">
        @include('admin.users.form', [
                'user' => new \App\Models\User,
                'action' => route('admin.users.store')
            ])
       
    </x-card>

 @endsection


@section('scripts')
<script src="{{ asset('limitless/js/vendor/forms/inputs/passy.js') }}"></script>
<script src="{{ asset('limitless/demo/pages/form_controls_extended.js') }}"></script>

{{-- <script src="{{ asset('limitless/js/vendor/uploaders/fileinput/fileinput.min.js') }}"></script> --}}
{{-- <script src="{{ asset('limitless/demo/pages/uploader_bootstrap.js') }}"></script> --}}

<script src="{{ asset('limitless/js/vendor/media/cropper.min.js') }}"></script>
{{-- <script src="{{ asset('limitless/demo/pages/extension_image_cropper.js') }}"></script> --}}

<script>
    $('.generate-text').click(function() {
        setTimeout(() => {
            let passVal = $('#password').val();
            $('#password_confirmation').val(passVal);
        }, 200);
    });

    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            $('#has_dp').val(1);

            reader.onload = function (e) {
                $('#imgPrev').attr('src', e.target.result);
                $('#toCrop').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);

            document.querySelector('.profile-picture-blob').files = input.files;

            $('.show-btn').removeClass('d-none');
        }
    }

    const elBasic = document.querySelector('#toCrop');
    let cropper = null;

    $('.crop-btn').click(function() {
        setTimeout(() => {

            var cropOptions = {
                aspectRatio: 1 / 1,
            };

            cropper = new Cropper(elBasic, cropOptions);
            cropper.enable();

        }, 500);
    });

    $('#doneCropping').click(function() {
        result = cropper.getCroppedCanvas().toDataURL('image/jpeg');
        console.log(result);
        // $('#profile-picture-blob').val(result);
        let resultBlob = cropper.getCroppedCanvas().toBlob((blob) => {
            console.log('BLOB DATA', blob);

            let fileName = 'testcrop.jpg';
            let file = new File([blob],  fileName, { 
                type: "image/jpeg", 
                lastModified: new Date() 
            });

            let container = new DataTransfer(); 
            container.items.add(file);

            console.log(container.files);

            document.querySelector('.profile-picture-blob').files = container.files;
        });

        $('#imgPrev').attr('src', result);
        $('#toCrop').attr('src', result);

        $('#cropProfilePic').modal('hide');

        cropper.destroy();
    });

    $(".profile-picture").change(function(){
        readURL(this);
    });

    $('.remove-pic-btn').click(function() {
        if (cropper) {
            cropper.destroy();
        }

        let defaultUrl = $('#default-pic').val();

        $('#has_dp').val(0);

        $('#profile-picture').val('');

        document.querySelector('.profile-picture-blob').files = null;
        
        $('#imgPrev').attr('src', defaultUrl);
        $('#toCrop').attr('src', defaultUrl);

        $('.show-btn').addClass('d-none');
    });
</script>
@endsection

