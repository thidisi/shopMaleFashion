@extends('backend.layout_admin_login')
@php
$title = 'Login';
@endphp
@section('content')
    <h4 class="mt-0">Sign In</h4>
    <p class="text-muted mb-4">Enter your email address and password to access account.</p>
    @empty(!session('invalidLogin'))
        <div class="alert alert-danger mt-2" role="alert">
            {{ session('invalidLogin') }}
        </div>
    @endempty
    @empty(!session('registerSuccess'))
        <div class="alert alert-success mt-2" role="alert">
            {{ session('registerSuccess') }}
        </div>
    @endempty
    <!-- form -->
    <form action="{{ route('admin.handle.login') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="">Username Or Email</label>
            <input class="form-control" type="text" required="" placeholder="Enter your username" name="user_name">
        </div>
        <div class="form-group">
            <a href="#" class="text-muted float-right"><small>Forgot your password?</small></a>
            <label for="password">Password</label>
            <input class="form-control" type="password" required="" id="password" placeholder="Enter your password" name="password">
        </div>
        {{-- <div class="form-group mb-3">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="checkbox-signin">
                <label class="custom-control-label" for="checkbox-signin">Remember me</label>
            </div>
        </div> --}}
        <div class="form-group mb-0 text-center">
            <button class="btn btn-primary btn-block" type="submit"><i class="mdi mdi-login"></i> Log In </button>
        </div>
        <!-- social-->
        <div class="text-center mt-4">
            <p class="text-muted font-16">Sign in with</p>
            <ul class="social-list list-inline mt-3">
                {{-- <li class="list-inline-item">
                    <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i
                            class="mdi mdi-facebook"></i></a>
                </li>
                <li class="list-inline-item">
                    <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i
                            class="mdi mdi-google"></i></a>
                </li> --}}
                <li class="list-inline-item">
                    <a href="{{ route('admin.auth.redirect', 'gitlab') }}" class="social-list-item border-info text-info"><i
                            class="mdi mdi-gitlab"></i></a>
                </li>
                {{--
                <li class="list-inline-item">
                    <a href="{{ route('admin.auth.redirect', 'github') }}" class="social-list-item border-secondary text-secondary"><i
                            class="mdi mdi-github-circle"></i></a>
                </li> --}}
            </ul>
        </div>
    </form>
    <!-- Footer-->
    <footer class="footer footer-alt">
        <p class="text-muted">Don't have an account? <a href="{{ route('admin.register') }}" class="text-muted ml-1"><b>Sign Up</b></a></p>
    </footer>

@endsection
