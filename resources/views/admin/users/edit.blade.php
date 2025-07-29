@extends('layouts.app')

@section('styles')
    <style>
        .password-div .label-required::after {
            content: none;
        }
        .file-thumbnail-footer {
            display: none;
        }

        .file-preview {
            width: 45% !important;
        }
    </style>
@endsection

@section('banner')
   <x-banner :current-page="'Edit User'"></x-banner>
@endsection

@section('content')

    <x-card :heading="'User Form'">
        @include('admin.users.form', [
            'user' => $user,
            'action' => route('admin.users.update', ['user' => $user])
        ])
    </x-card>

@endsection

@section('scripts')
<script src="{{ asset('limitless/js/vendor/forms/inputs/passy.js') }}"></script>
<script src="{{ asset('limitless/demo/pages/form_controls_extended.js') }}"></script>

{{-- <script src="{{ asset('limitless/js/vendor/uploaders/fileinput/fileinput.min.js') }}"></script> --}}
{{-- <script src="{{ asset('limitless/demo/pages/uploader_bootstrap.js') }}"></script> --}}
<script src="{{ asset('limitless/js/vendor/media/cropper.min.js') }}"></script>

<script>
    let hasProfilePic = "{!! $user->profile_picture != null !!}";

    const elBasic = document.querySelector('#toCrop');
    let cropper = null;

    $('.generate-text').click(function() {
        setTimeout(() => {
            let passVal = $('#password').val();
            $('#password_confirmation').val(passVal);
        }, 200);
    });

    $(document).ready(function() {
        if (hasProfilePic) {

            $('#has_dp').val(1);

            let profilePicUrl = $('#imgPrev').attr('src');
            let dpFilename = "{!! $user->profile_pic_filename !!}";

            $('#imgPrev').attr('src', profilePicUrl);
            $('#toCrop').attr('src', profilePicUrl);
        }

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

    $('.crop-btn').click(function() {
        if (cropper) {
            cropper.destroy();
        }

        setTimeout(() => {

            var cropOptions = {
                aspectRatio: 1 / 1,
            };

            cropper = new Cropper(elBasic, cropOptions);
            cropper.enable();

        }, 200);
    });

    $('#doneCropping').click(function() {
        result = cropper.getCroppedCanvas().toDataURL('image/jpeg');

        let resultBlob = cropper.getCroppedCanvas().toBlob((blob) => {
            let fileName = $('.profile-picture').val().split('\\').pop();

            if (!fileName) {
                fileName = $('.existing-profile-picture').val().split('/').pop();
            }

            console.log(fileName);

            let file = new File([blob],  fileName, { 
                type: "image/jpeg", 
                lastModified: new Date() 
            });

            let container = new DataTransfer(); 
            container.items.add(file);

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

    if (hasProfilePic) {
        $('.show-btn').removeClass('d-none');
    }


    // const previewZoomButtonClasses = {
    //     rotate: 'btn btn-light btn-icon btn-sm',
    //     toggleheader: 'btn btn-light btn-icon btn-header-toggle btn-sm',
    //     fullscreen: 'btn btn-light btn-icon btn-sm',
    //     borderless: 'btn btn-light btn-icon btn-sm',
    //     close: 'btn btn-light btn-icon btn-sm'
    // };

    // const previewZoomButtonIcons = {
    //     prev: document.dir == 'rtl' ? '<i class="ph-arrow-right"></i>' : '<i class="ph-arrow-left"></i>',
    //     next: document.dir == 'rtl' ? '<i class="ph-arrow-left"></i>' : '<i class="ph-arrow-right"></i>',
    //     // rotate: '<i class="ph-arrow-clockwise"></i>',
    //     toggleheader: '<i class="ph-arrows-down-up"></i>',
    //     fullscreen: '<i class="ph-corners-out"></i>',
    //     borderless: '<i class="ph-frame-corners"></i>',
    //     close: '<i class="ph-x"></i>'
    // };

    // const fileActionSettings = {
    //     zoomClass: '',
    //     zoomIcon: '<i class="ph-magnifying-glass-plus"></i>',
    //     // dragClass: 'p-2',
    //     // dragIcon: '<i class="ph-dots-six"></i>',
    //     removeClass: '',
    //     removeErrorClass: 'text-danger',
    //     // removeIcon: '<i class="ph-trash"></i>',
    //     indicatorNew: '<i class="ph-file-plus text-success"></i>',
    //     indicatorSuccess: '<i class="ph-check file-icon-large text-success"></i>',
    //     indicatorError: '<i class="ph-x text-danger"></i>',
    //     indicatorLoading: '<i class="ph-spinner spinner text-muted"></i>'
    // };

    // let existingProfilePic = '{!! $user->profile_pic_path !!}';

    // let initPreview = existingProfilePic ? [ existingProfilePic ] : [];

    // $('.profile-picture').fileinput({
    //     browseLabel: 'Upload Profile Picture',
    //     browseIcon: '<i class="ph-file-plus me-2"></i>',
    //     uploadIcon: '<i class="ph-file-arrow-up me-2"></i>',
    //     removeIcon: '<i class="ph-x fs-base me-2"></i>',
    //     layoutTemplates: {
    //         icon: '<i class="ph-check"></i>'
    //     },
    //     uploadClass: 'btn btn-light',
    //     removeClass: 'btn btn-light',
    //     initialCaption: "No file selected",
    //     previewZoomButtonClasses: previewZoomButtonClasses,
    //     previewZoomButtonIcons: previewZoomButtonIcons,
    //     fileActionSettings: fileActionSettings,
    //     initialPreview: initPreview,
    //     // initialPreviewConfig: [
    //     //     {caption: 'Jane.jpg', size: 930321, key: 1, url: '{$url}', showDrag: false}
    //     // ],
    //     showCaption: false,
    //     initialPreviewAsData: true,
    //     overwriteInitial: true,
    //     dropZoneEnabled: false
    // });
</script>
@endsection
