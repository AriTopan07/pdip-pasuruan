@extends('layouts.auth')

@section('content')
    {{-- <style>
        .bg {
            background: #6a11cb;

            background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

            background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
        }
    </style> --}}

    <div class="bg min-vh-100 d-flex flex-column align-items-center justify-content-center py-4" id="auth">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-7 col-9 d-flex flex-column justify-content-center">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <div class="d-flex justify-content-center py-4">
                                <a href="" class="logo d-flex align-items-center w-auto">
                                    <h1 class="auth-title align-items-center">Register</h1>
                                </a>
                            </div>

                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <label>Name</label>
                                <div class="form-group position-relative has-icon-left mb-4">
                                    <input type="text" class="form-control form-control" name="name"
                                        placeholder="name" value="{{ old('username') }}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                                <label>Username</label>
                                <div class="form-group position-relative has-icon-left mb-4">
                                    <input type="text" class="form-control form-control" name="username"
                                        placeholder="Username" value="{{ old('username') }}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                    </div>
                                </div>
                                <label>Password</label>
                                <div class="form-group position-relative has-icon-left mb-4">
                                    <input type="password" class="form-control form-control" name="password"
                                        placeholder="Password" value="{{ old('password') }}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                </div>
                                <label>Confirm Password</label>
                                <div class="form-group position-relative has-icon-left mb-4">
                                    <input type="password" class="form-control form-control" name="confirm_password"
                                        placeholder="Confirm Password" value="{{ old('password') }}">
                                    <div class="form-control-icon">
                                        <i class="bi bi-shield-lock"></i>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-block btn-md shadow-md mt-4">Daftar</button>
                            </form>
                            <h6 class="mt-4">
                                <a href="{{ route('login') }}">Login</a>
                            </h6>
                        </div>
                    </div>
                    <p>&copy; DPC PDI Perjuangan Kab. Pasuruan 2024</p>
                </div>
            </div>
        </div>
    </div>
@endsection
