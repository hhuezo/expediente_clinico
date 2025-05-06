@extends('layouts.app')

@section('content')
    <div class="row authentication authentication-cover-main mx-0">
        <div class="col-xxl-6 col-xl-7">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-xxl-7 col-xl-9 col-lg-6 col-md-6 col-sm-8 col-12">
                    <div class="card custom-card my-auto border">
                        <div class="card-body p-5">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <p class="h3 mb-2 text-center">Demo Expediente</p>
                                <p class="mb-4 text-muted op-7 fw-normal text-center">Inicio de sesión</p>

                                <div class="row gy-3">
                                    <div class="col-xl-12">
                                        <label for="signup-firstname" class="form-label text-default">Email<sup
                                                class="fs-12 text-danger">*</sup></label>

                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required autocomplete="email" autofocus>

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="col-xl-12">
                                        <label for="signup-password" class="form-label text-default">Password<sup
                                                class="fs-12 text-danger">*</sup></label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            required autocomplete="current-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div>
                                <div class="d-grid mt-4">
                                    <button class="btn btn-primary" style="height: 43px; font-size: 0.95rem">Acceder</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-6 col-xl-5 col-lg-12 d-xl-block d-none px-0" style="background-image: url('{{ asset('assets/images/background.jpg') }}'); background-size: cover; background-position: center; height: 100vh;">

        </div>
    </div>
@endsection
