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

<x-card :heading="'Profile'">
<x-entity-form :model="authUser()" :action="route('admin.profile.update', ['profile' => authUser()->id])" :return-url="route('admin.users.index')">

    <div class="row">
        <div class="col-12 col-md-3 mt-3 mt-md-0">

            <div class="mb-3">
                <img id="imgPrev" src="{{ asset(authUser()->profile_pic_path) }}" alt="" width="70%">
                <input type="hidden" id="default-pic" value="{{ asset(authUser()->default_profile_pic_path) }}">
                <x-button type="button" :action="'remove'" class="d-none show-btn btn-danger remove-pic-btn mt-2">Remove Image</x-button>
                <x-button type="button" class="d-none show-btn crop-btn mt-2" data-bs-target="#cropProfilePic" data-bs-toggle="modal">Crop Image</x-button>

                <input type="hidden" name="has_dp" id="has_dp" value="">
            </div>

            <input type="hidden" class="existing-profile-picture" value="{{ asset(authUser()->profile_pic_path) }}">

            <input type="file" class="profile-picture" accept="image/png, image/gif, image/jpeg" >
            <input type="file" class="profile-picture-blob d-none" name="profile_picture">

            <x-input-error :messages="$errors->get('profile_picture')" class="mt-2" />
        </div>
        <div class="col-12 col-md-9 mt-3 mt-md-0">
            <div class="row mt-2">
                <!-- First Name -->
                <div class="col-12 col-md-4 mt-3 mt-md-0">
                    <x-input-label class="label-required" for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" class="block mt-1 w-full" 
                                :error="$errors->get('first_name')" 
                                type="text" name="first_name" 
                                :icon="'ph-user-circle'"
                                :value="optional(authUser())->first_name ? optional(authUser())->first_name : old('first_name')" required/>
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>
                <!-- Last Name -->
                <div class="col-12 col-md-4 mt-3 mt-md-0">
                    <x-input-label class="label-required"  for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" class="block mt-1 w-full" 
                                type="text" 
                                :error="$errors->get('last_name')" 
                                name="last_name" 
                                :icon="'ph-user-circle'"
                                :value="optional(authUser())->last_name ? optional(authUser())->last_name : old('last_name')" required/>
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>
                <!-- Email Address -->
                <div class="col-12 col-md-4 mt-3 mt-md-0">
                    <x-input-label class="label-required"  for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" 
                                type="email" 
                                name="email" 
                                :error="$errors->get('email')" 
                                :icon="'ph-at'"
                                :disabled="authUser()->isRegularAdmin()"
                                :value="optional(authUser())->email ? optional(authUser())->email : old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>
        </div>
    </div>

    

    <div class="modal fade" id="cropProfilePic"  tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="cropProfilePicLabel">
                    Crop Image
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="background:none; padding: 0; border:0; font-size: 24px;">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-10">
                            <img src="" id="toCrop" width="70%">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <x-button type="button" data-bs-dismiss="modal" class="btn-primary me-2" :action="'back'">Cancel</x-button>
                    <x-button type="button" class="btn-success" id="doneCropping">Done</x-button>
                </div>
                </form>
            </div>
        </div>
    </div>
</x-entity-form>
</x-card>

@endsection

@section('scripts')
<script src="{{ asset('limitless/js/vendor/forms/inputs/passy.js') }}"></script>
<script src="{{ asset('limitless/demo/pages/form_controls_extended.js') }}"></script>

{{-- <script src="{{ asset('limitless/js/vendor/uploaders/fileinput/fileinput.min.js') }}"></script> --}}
{{-- <script src="{{ asset('limitless/demo/pages/uploader_bootstrap.js') }}"></script> --}}
<script src="{{ asset('limitless/js/vendor/media/cropper.min.js') }}"></script>

<script>
    let hasProfilePic = "{!! authUser()->profile_picture != null !!}";

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
            let dpFilename = "{!! authUser()->profile_pic_filename !!}";

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

    // let existingProfilePic = '{!! authUser()->profile_pic_path !!}';

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