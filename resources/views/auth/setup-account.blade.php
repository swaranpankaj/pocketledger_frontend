
@extends('layouts.app')

@section('content')
 <!-- setup-account area start  -->
 <section class="setup-account signup-area confirmation-area dashboard-area">
         <div class="container">
            <div class="signup-area-wrapper">
               <div class="signup-main">
                  <div class="signup-top">
                     <h2 class="title fw-bold mb-3">Let's finish setting up your account</h2>
                     <p class="confirmation-desc signup-desc pe-0">We've sent an email to <a href="mailto:{{$user->email}}" class="fw-bold text-black">{{$user->email}}</a> to confirm your account. If you don't receive the email within a couple minutes, please check the spam folder in your email program. The subject line of the email is "Confirmation instructions."</p>
                  </div>
                  @if ($errors->any())
                  <div class="alert alert-danger">
                     <ul>
                           @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                           @endforeach
                     </ul>
                  </div>
               @endif
                  <form action="{{route('account.complete')}}" method="POST" class="account-form setup-form" id="accountForm">
                  @csrf
                     <div class="form-input-wrapper d-flex flex-column flex-sm-row">
                        <div class="form-input w-100">
                           <label for="f-name" class="d-inline-block fw-bold mb-1">First Name*</label>
                           <input type="text" id="f-name" class="input-field w-100" name="first_name" value="{{ old('first_name', $user->first_name) }}">
                           <div id="firstnameError" class="text-danger"></div>
                        </div>
                        <div class="form-input w-100">
                           <label for="l-name" class="d-inline-block fw-bold mb-1">Last Name*</label>
                           <input type="text" id="l-name" class="input-field w-100" name="last_name" value="{{ old('last_name', $user->last_name) }}">
                           <div id="lastnameError" class="text-danger"></div>
                        </div>
                     </div>
                     <div class="form-input w-100">
                        <label for="email" class="d-inline-block fw-bold mb-1">Email address*</label>
                        <input type="email" id="email" class="input-field w-100" value="{{$user->email}}" disabled>
                     </div>
                     <div class="form-input gender-select">
                        <label for="select-gender" class="d-inline-block fw-bold mb-1" >Choose one*</label>
                        <select type="text" id="select-gender" class="input-field w-100" name="gender">
                        <option value="">Select an option</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        </select>
                        <p class="mb-0 mt-1">Why do we ask for this information?</p>
                        <div id="genderError" class="text-danger"></div>
                     </div>
                     <div class="form-btn-wrapper pt-4">
                        <button type="submit" class="form-btn signup-btn theme-btn big d-inline-block fw-bold">Continue</button>
                     </div>
                  </form>
               </div>
            </div>   
         </div>
      </section>
      <!-- setup-account area end  -->
      @endsection