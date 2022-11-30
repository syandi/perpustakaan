@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('Masuk') }}</div>

                <div class="card-body">
                    @include('admin-lte/flash')
                    
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group">
                            <!-- <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Username') }}</label> -->

                            <div class="input-group mb-3">
                              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required autocomplete="email" autofocus>
                              <div class="input-group-append">
                                <div class="input-group-text">
                                  <span class="fas fa-envelope"></span>
                                </div>
                              </div>
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <!-- <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label> -->

                            <div class="input-group mb-3">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">
                                <div class="input-group-append">
                                <div class="input-group-text">
                                  <span class="fas fa-lock"></span>
                                </div>
                              </div>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Ingat saya') }}
                                    </label>
                                </div>
                            </div>
                        </div> -->
                        <div class="row">
                          <div class="col-8">
                            <div class="icheck-primary sr-only">
                              <input type="checkbox" id="remember">
                              <label for="remember">
                                {{ __('Ingat Saya') }}
                              </label>
                            </div>
                          </div>
                          <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Masuk') }}</button>
                          </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
