@extends('layout.app')
@section('content')
    <div class="auth-wrapper d-flex no-block justify-content-center align-items-center position-relative">
        <div class="auth-box row">
            <div class="col-lg-7 col-md-5 modal-bg-img" style="background-image: url({{ asset('assets/images/auth.jpg') }});">
            </div>
            <div class="col-lg-5 col-md-7 bg-white">
                <div class="p-3 login-form {{ Request::segment(1) == 'register' ? 'd-none' : '' }}">
                    <h2 class="mt-3 text-center">Sign In</h2>
                    <p class="text-center">Enter your email address and password to access admin panel.</p>
                    <form class="mt-4" method="POST" action="{{ route('auth.login') }}">
                        @csrf
                        {{ method_field("POST") }}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label class="form-label text-dark" for="email">Email</label>
                                    <input class="form-control" type="email" name="email" id="email" required
                                        placeholder="enter your email">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <label class="form-label text-dark" for="password">Password</label>
                                    <input class="form-control" required id="password" name="password" type="password"
                                        placeholder="enter your password">
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn w-100 btn-dark">Sign In</button>
                            </div>
                            <div class="col-lg-12 text-center mt-5">
                                Don't have an account? <a href="#" class="text-danger switch-login">Sign Up</a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="p-3 register-form {{ Request::segment(1) == 'login' ? 'd-none' : '' }}">
                    <h2 class="mt-3 text-center">Sign Up for Free</h2>
                    <form class="mt-4" method="POST" action="{{ route('auth.register') }}">
                        @csrf
                        {{ method_field("POST") }}
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <input class="form-control" required name="name" type="text"
                                        placeholder="your name">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <input class="form-control" required name="email" type="email"
                                        placeholder="email address">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group mb-3">
                                    <input class="form-control" required name="password" type="password"
                                        placeholder="password">
                                </div>
                            </div>
                            <div class="col-lg-12 text-center">
                                <button type="submit" class="btn w-100 btn-dark">Sign Up</button>
                            </div>
                            <div class="col-lg-12 text-center mt-5">
                                Already have an account? <a href="#" class="text-danger switch-register">Sign In</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
