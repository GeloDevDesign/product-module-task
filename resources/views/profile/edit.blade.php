@extends('layouts.app')

@section('banner')
   <x-banner :current-page="'View Users'"></x-banner>
@endsection


@section('content')
    <div class="text-end mb-4">
        <a href="{{ route('admin.profile.edit-profile') }}">
            <button type="button" class="btn btn-labeled btn-labeled-start btn-primary btn-primary pull-right me-2">
                <span class="btn-labeled-icon bg-black bg-opacity-20">
                    <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                </span>
                Update Profile
            </button>
        </a>

        <a href="{{ route('admin.profile.update-password') }}">
            <button type="button" class="btn btn-labeled btn-labeled-start btn-primary btn-primary pull-right me-2">
                <span class="btn-labeled-icon bg-black bg-opacity-20">
                    <i class="fa fa-user-lock" aria-hidden="true"></i>
                </span>
                Change Password
            </button>
        </a>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="sidebar-section-body text-center mb-3 mt-3">
                    <div class="card-img-actions d-inline-block mb-3">
                        <img class="img-fluid rounded-circle" src="{{ asset($user->profile_pic_path) }}" width="150" height="150" alt="">
                        <div class="card-img-actions-overlay card-img rounded-circle">
                            <a href="#" class="btn btn-outline-white btn-icon rounded-pill">
                                <i class="ph-pencil"></i>
                            </a>
                        </div>
                    </div>

                    <h6 class="mb-0">{{ $user->full_name }}</h6>
                    <span class="text-muted">{{ $user->type_name }}</span>
                </div>

                {{-- <ul class="nav nav-sidebar">
                    <li class="nav-item">
                        <a href="#profile" class="nav-link active" data-bs-toggle="tab">
                            <i class="ph-user me-2"></i>
                                My profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#schedule" class="nav-link" data-bs-toggle="tab">
                            <i class="ph-calendar me-2"></i>
                            Schedule
                            <span class="fs-sm fw-normal text-muted ms-auto">02:56pm</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#inbox" class="nav-link" data-bs-toggle="tab">
                            <i class="ph-envelope me-2"></i>
                            Inbox
                            <span class="badge bg-secondary rounded-pill ms-auto">29</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#orders" class="nav-link" data-bs-toggle="tab">
                            <i class="ph-shopping-cart me-2"></i>
                            Orders
                            <span class="badge bg-secondary rounded-pill ms-auto">16</span>
                        </a>
                    </li>
                </ul> --}}
            </div>
        </div>
    </div>
@endsection