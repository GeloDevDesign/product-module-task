@extends('layouts.app')

@section('banner')
   <x-banner :current-page="'Change Password'" ></x-banner>
@endsection

@section('content')

<x-card :heading="'Password Form'">
    <x-entity-form :model="$user" :action="route('admin.users.update-password', $user)" :return-url="route('admin.users.index')">
    
        <div class="row mt-2">
            <!-- Password -->
            <div class="col-12 col-md-4 mt-3 password-div">
                <x-input-label class="label-required"  for="password" :value="__('Password')" />
    
                <x-text-input id="password" class="block mt-1 w-full text-indicator"
                                type="password"
                                name="password" 
                                :icon="'ph-lock'"
                                :error="$errors->get('password')"/>
                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
                <i>Minimum of 8 characters with at least 1 number</i><br>
    
                <button type="button" class="btn btn-primary generate-text mt-3">Generate password</button>
            </div>
            <!-- Confirm Password -->
            <div class="col-12 col-md-4 mt-3 password-div">
                <x-input-label class="label-required" for="password_confirmation" :value="__('Confirm Password')" />
    
                <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation"
                                :icon="'ph-lock'"
                                :error="$errors->get('password_confirmation')" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>
    
    </x-entity-form>
</x-card>


@endsection

@section('scripts')
<script src="{{ asset('limitless/js/vendor/forms/inputs/passy.js') }}"></script>
<script src="{{ asset('limitless/demo/pages/form_controls_extended.js') }}"></script>

<script>
    $('.generate-text').click(function() {
        setTimeout(() => {
            let passVal = $('#password').val();
            $('#password_confirmation').val(passVal);
        }, 200);
    });
</script>
@endsection