@extends('layouts.mein')

@section('header-title')
Simple CRM dashboard
@endsection

@section('scrypts')
    @vite(['resources/js/dashboardmein.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection



@section('content')

    @include('includes.sidebar')


    <div class="main">

        @include('includes.topbar')

        
        <div id="content" class="content">

            
            @include('static.dashboard.pages.home')

        </div>

        @include('includes.modals')
        @include('includes.footer')

    </div>

    

@endsection