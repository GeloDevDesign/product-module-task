@extends('layouts.app')

@section('banner')
   <x-banner :current-page="'General Settings'"></x-banner>
@endsection

@section('styles')
<style>
    .tokenfield {
        margin-top: 0.3125rem!important;
    }
</style>
    
@endsection

@section('content')
<x-card :heading="'General Settings'">
    <div class="row">
        <div class="col-md-6">
            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-solid-dark bg-secondary mb-3">
                <li class="nav-item">
                    <a href="#main-tab" class="nav-link {{ !request()->input('tab') || request()->input('tab') == 'main' ? 'active' : '' }}" aria-selected="{{ !request()->input('tab') || request()->input('tab') == 'main'}}" data-bs-toggle="tab">
                        Main
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#terms-conditions-tab" class="nav-link {{ request()->input('tab') == 'terms-conditions' ? 'active' : '' }}" aria-selected="{{ !request()->input('tab') || request()->input('tab') == 'terms-conditions'}}"  data-bs-toggle="tab">
                        Terms & Conditions
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#dashboard-text-tab" class="nav-link {{ request()->input('tab') == 'dashboard-text' ? 'active' : '' }}" data-bs-toggle="tab">
                        Dashboard Text
                    </a>
                </li>
                {{-- <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Dropdown</a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="#" class="dropdown-item">Dropdown tab</a>
                        <a href="#" class="dropdown-item">Another tab</a>
                    </div>
                </li> --}}
            </ul>
        </div>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade {{ !request()->input('tab') || request()->input('tab') == 'main' ? 'show active' : '' }}" id="main-tab">
            <x-entity-form :model="$generalSettings" :action="route('admin.general-settings.update', $generalSettings)" :return-url="route('admin.general-settings.index')">
                <input type="hidden" name="tab" value="main">
                <div class="row">
                    <div class="col-12 col-md-6 mt-3 mt-md-0">
                        <x-input-label class="label-required" for="notification_emails" :value="__('Notification Emails')" />
                        <x-text-input id="notification_emails" :icon="'ph-at'" class="block mt-1 w-full tokenfield-blur" :error="$errors->get('notification_emails')" type="text" name="notification_emails" />
                        <x-input-error :messages="$errors->get('notification_emails')" class="mt-2" />
                    </div>
        
                    <div class="col-12 mt-4">
                        <x-checkbox :label="'Maintenance Mode'" :fieldName="'maintenance_mode'" :checked="optional($generalSettings)->maintenance_mode"/>
                        <x-input-error :messages="$errors->get('maintenance_mode')" class="mt-2" />
                    </div>
                </div>
            </x-entity-form>
        </div>

        <div class="tab-pane fade {{ request()->input('tab') == 'terms-conditions' ? 'show active' : '' }}" id="terms-conditions-tab">
            <x-entity-form :model="$generalSettings" :action="route('admin.general-settings.update', $generalSettings)" :return-url="route('admin.general-settings.index')">
                <input type="hidden" name="tab" value="terms-conditions">
                <div class="row">
                    <textarea class="form-control" id="ckeditor_terms_and_conditions" name="terms_and_conditions">
                        {!! optional($generalSettings)->terms_and_conditions !!}
                    </textarea>
                </div>
            </x-entity-form>
        </div>

        <div class="tab-pane fade {{ request()->input('tab') == 'dashboard-text' ? 'show active' : '' }}" id="dashboard-text-tab">
            <x-entity-form :model="$generalSettings" :action="route('admin.general-settings.update', $generalSettings)" :return-url="route('admin.general-settings.index')">
                <input type="hidden" name="tab" value="dashboard-text">
                <div class="row">
                    <textarea class="form-control" id="ckeditor_dashboard_text" name="dashboard_text">
                        {!! optional($generalSettings)->dashboard_text !!}
                    </textarea>
                </div>
            </x-entity-form>
        </div>
    </div>
    {{-- <x-entity-form :model="$generalSettings" :action="route('admin.general-settings.update', $generalSettings)" :return-url="route('admin.general-settings.index')">
        <div class="row">
            <div class="col-12 col-md-6 mt-3 mt-md-0">
                <x-input-label class="label-required" for="notification_emails" :value="__('Notification Emails')" />
                <x-text-input id="notification_emails" :icon="'ph-at'" class="block mt-1 w-full tokenfield-blur" :error="$errors->get('notification_emails')" type="text" name="notification_emails" />
                <x-input-error :messages="$errors->get('notification_emails')" class="mt-2" />
            </div>

            <div class="col-12 mt-4">
                <x-checkbox :label="'Maintenance Mode'" :fieldName="'maintenance_mode'" :checked="optional($generalSettings)->maintenance_mode"/>
                <x-input-error :messages="$errors->get('maintenance_mode')" class="mt-2" />
            </div>

            <div class="col-12 mt-4">
                <textarea class="form-control" id="ckeditor_classic_prefilled" name="terms_and_conditions">
                    {!! optional($generalSettings)->terms_and_conditions !!}
                </textarea>
            </div>
    
        </div>
    </x-entity-form> --}}
</x-card>
@endsection

@section('scripts')
<script src="{{ asset('limitless/js/vendor/forms/tags/tokenfield.min.js') }}"></script>
<script>
    let emails = JSON.parse('{!! json_encode($generalSettings->notification_emails) !!}');

    ClassicEditor.create(document.querySelector('#ckeditor_terms_and_conditions'), {
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        }
    }).catch(error => {
        console.error(error);
    });

    ClassicEditor.create(document.querySelector('#ckeditor_dashboard_text'), {
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' }
            ]
        }
    }).catch(error => {
        console.error(error);
    });

    let emailCollection = [];

    if (emails && emails.length > 0) {
        emails.forEach((email, key) => {
            emailCollection.push ({
                id: key + 1,
                name: email
            });
        });
    }

    setTimeout(() => {
        const tfBlur = new Tokenfield({
            el: document.querySelector('.tokenfield-blur'),
            items: emailCollection,
            setItems: emailCollection,
            itemValue: 'name',
            addItemOnBlur: true,
            multiple: true,
            addItemsOnPaste: true,
        });
    }, 300);
</script>
@endsection