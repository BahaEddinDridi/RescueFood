@extends('layouts.app')

@section('content')
<section class="vh-100" style="margin-top: 200px;">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-9 col-lg-6 col-xl-5">
        <img class="w-100" src="{{asset('img/carousel-1.jpg')}}" alt="Image"> <!-- Image for the login page -->
      </div>
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form method="POST" action="{{ route('login') }}">
          @csrf

          <!-- Email input -->
          <div class="form-outline mb-4">
            <label class="form-label" for="email">Email </label>
            <input type="email" id="email" class="form-control form-control-lg @error('email') is-invalid @enderror"
              name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
              placeholder="Enter your adresse mail" />

            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" class="form-control form-control-lg @error('password') is-invalid @enderror"
              name="password" required autocomplete="current-password"
              placeholder="Enter your password" />

            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>

          <div class="d-flex justify-content-between align-items-center">
            <!-- Checkbox -->
            <div class="form-check mb-0">
              <input class="form-check-input me-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
              <label class="form-check-label" for="remember">
                Remember me
              </label>
            </div>
            <a href="{{ route('password.request') }}" class="text-body">Forgot password?</a>
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">
              Login
            </button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? 
              <a href="{{ route('register') }}" class="link-danger">Register</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection
