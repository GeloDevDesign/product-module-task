<x-entity-form :model="$user" :action="$action" :return-url="route('admin.users.index')">

    <div class="row">
        <div class="col-12 col-md-3 mt-3 mt-md-0">

            <div class="mb-3">
                <img id="imgPrev" src="{{ asset($user->profile_pic_path) }}" alt="" width="70%">
                <input type="hidden" id="default-pic" value="{{ asset($user->default_profile_pic_path) }}">
                <x-button type="button" :action="'remove'" class="d-none show-btn btn-danger remove-pic-btn mt-2">Remove Image</x-button>
                <x-button type="button" class="d-none show-btn crop-btn mt-2" data-bs-target="#cropProfilePic" data-bs-toggle="modal">Crop Image</x-button>

                <input type="hidden" name="has_dp" id="has_dp" value="">
            </div>

            <input type="hidden" class="existing-profile-picture" value="{{ asset($user->profile_pic_path) }}">

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
                                :value="optional($user)->first_name ? optional($user)->first_name : old('first_name')" required/>
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
                                :value="optional($user)->last_name ? optional($user)->last_name : old('last_name')" required/>
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
                                :value="optional($user)->email ? optional($user)->email : old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!-- Type -->
                <div class="col-12 col-md-4 mt-3 mt-md-0">
                    <x-select :label="'Type'" :required="true" :error="$errors->get('type')" name="type" :icon="'ph-at'" :value="old('type') ? old('type') : optional($user)->type">
                        @foreach (\App\Models\User::$types as $type => $val)
                        <option value="{{ $type }}" {{ (old('type') ?? optional($user)->type) == $type ? 'selected' : '' }}>{{ $val }}</option>
                        @endforeach
                    </x-select>
                    {{-- <x-input-error :messages="$errors->get('type')" class="mt-2" /> --}}
                </div>
        
                @if (!$user->exists)
                <!-- Password -->
                <div class="col-12 col-md-4 mt-3 password-div">
                    <x-input-label class="label-required"  for="password" :value="__('Password')" />
        
                    <x-text-input id="password" class="block mt-1 w-full text-indicator"
                                    type="password"
                                    name="password" 
                                    :icon="'ph-lock'"
                                    :error="$errors->get('password')"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2"/>
        
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
                @endif
                <!-- Active -->
                <div class="col-12 mt-4">
                    <x-checkbox :label="'Active'" :fieldName="'active'" :checked="optional($user)->active"/>
                    <x-input-error :messages="$errors->get('active')" class="mt-2" />
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