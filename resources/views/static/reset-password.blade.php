@extends('layouts.mein')

@section('header-title')
Password recovery
@endsection

@section('scrypts')
   @vite(['resources/js/app.js'])
@endsection



@section('content')


    <div class="auth-container">
        <div class="auth-card">
            <h3 class="text-center mb-4">Create a new password</h3>

            <form id="NewPasswordForm">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="mb-3">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="c_password" class="form-label">Confirm password</label>
                        <input type="password" id="c_password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="d-flex justify-content-between mb-3">
                    <a href="{{ route('register') }}">Registration</a>
                    <a href="{{ route('home') }}">Home</a>
                </div>

                <button type="submit" class="btn btn-primary w-100">Recovery</button>

               
            </form>

            <div id="NewPasswordMessage" class="mt-3 text-center"></div>
        </div>
    </div>

    @include('includes.footer')

@endsection