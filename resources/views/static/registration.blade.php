@extends('layouts.mein')

@section('header-title')
Registering a new user
@endsection

@section('scrypts')
    @vite(['resources/js/meinregistration.js'])
@endsection

@section('content')


    @include('includes.registrationform')

    @include('includes.footer')

@endsection


