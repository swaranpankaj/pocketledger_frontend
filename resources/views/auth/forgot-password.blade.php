@extends('layouts.app')

@section('content')
<!-- overlay -->
<div class="overlay position-fixed w-100 h-100 top-0 start-0 d-lg-none"></div>
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<section class="myprofile-area">
         <div class="container">
            <div class="myprofile-wrapper dashboard-area-wrapper mx-auto">
               <div class="myprofile-title dasboard-title">
               <h4 class="fw-bold"> {{ __('Forgot your password?') }}</h4>
               <p class="mb-3 pb-1">No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.</p>
        </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="profile-form signup-form p-3">
        @csrf

        <!-- Email Address -->
        <div class="form-input w-100">
            <x-input-label class="d-inline-block fw-bold mb-1" for="email" :value="__('Email')" />
            <x-text-input id="email" class="input-field w-100" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div  class="form-btn-wrapper d-flex align-items-center">
        <button type="submit" class="form-btn signup-btn theme-btn big d-inline-block fw-bold">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
    </div>
         </div>
      </section>
    @endsection
