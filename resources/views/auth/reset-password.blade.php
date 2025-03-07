@extends('layouts.app')

@section('content')

<section class="myprofile-area">

         <div class="container">
            <div class="myprofile-wrapper dashboard-area-wrapper mx-auto">
               <div class="myprofile-title dasboard-title">
                  <h4 class="fw-bold">Your profile</h4>
                  <p class="mb-3 pb-1">Please use the form below to update your password. Keeping your password secure is essential for protecting your account and personal information.</p>
               </div>
    <form method="POST" action="{{ route('password.store') }}" class="profile-form signup-form p-3" id="passwordForm">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="form-input w-100">
            <x-input-label for="email" :value="__('Current Password')" class="d-inline-block fw-bold mb-1"/>
            <x-text-input id="email" class="input-field w-100" type="password" name="old_password" :value="old('password', $request->password)" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('old_password')" class="mt-2 text-danger" />
        </div>

        <!-- Password -->
        <div class="form-input w-100">
            <x-input-label for="password" :value="__('New Password')" class="d-inline-block fw-bold mb-1"/>
            <x-text-input id="password" class="input-field w-100" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
        </div>

        <!-- Confirm Password -->
        <div class="form-input w-100">
            <x-input-label for="password_confirmation" :value="__('Confirm New Password')" class="d-inline-block fw-bold mb-1"/>
            <x-text-input id="password_confirmation" class="input-field w-100"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger" />
        </div>

        <div class="form-btn-wrapper d-flex align-items-center">
        <button type="submit" class="form-btn signup-btn theme-btn d-inline-block fw-bold">
                {{ __('Update Password') }}
            </button>
        </div>
        <p class="note mb-0 mt-3 pt-1">Note: After clicking <b>"Update Password,"</b> you will be logged out of your account. Please log in again using your new credentials.</p>
    </form>
    </div>
         </div>
      </section>
    @endsection
