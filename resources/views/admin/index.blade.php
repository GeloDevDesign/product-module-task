@extends('layouts.app')

{{-- @php
    $loggedIn = authUser();
    $loggedIn->last_login = now();
    $loggedIn->save();
@endphp --}}


@section('banner')
   <x-banner :current-page="'Dashboard'"></x-banner>
@endsection

@section('content')
   {!! $contents !!}
@endsection

