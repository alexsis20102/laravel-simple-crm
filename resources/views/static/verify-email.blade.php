@extends('layouts.mein')

@section('header-title')
Verify E-Mail address
@endsection

@section('scrypts')
    @vite(['resources/js/meinregistration.js'])
@endsection



@section('content')


    <div class="auth-container">
        <div class="auth-card">
            <h3 class="text-center mb-4">Receiving a verification link again</h3>

            <form id="ResendLinkForm">
                @csrf
                <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="E-mail">
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                    <a href="{{ route('home') }}">Home</a>
                </div>

                <button type="submit" class="btn btn-primary w-100">Send link again</button>

               
            </form>

            <div id="ResendLinkMessage" class="mt-3 text-center"></div>
        </div>
    </div>

    @include('includes.footer')

@endsection