@extends('layouts.mein')

@section('header-title')
Simple CRM
@endsection

@section('scrypts')
    @vite(['resources/js/app.js'])
@endsection



@section('content')


    @include('includes.authform')

    @include('includes.footer')

@endsection


