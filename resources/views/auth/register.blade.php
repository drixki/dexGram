@extends('layouts.auth')

@section('content')
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-sidebartype="full" data-sidebar-position="fixed"
        data-header-position="fixed">
        <div class="position-relative overflow-hidden radial-gradient min-vh-100">
            <div class="position-relative z-index-5">
                <div class="row">
                    <div class="col-xl-7 col-xxl-8">
                        <div class="d-none d-xl-flex align-items-center justify-content-center"
                            style="height: calc(100vh - 80px);">
                            <img src="https://demos.adminmart.com/premium/bootstrap/modernize-bootstrap/package/dist/images/backgrounds/login-security.svg"
                                alt="" class="img-fluid" width="500">
                        </div>
                    </div>
                    <div class="col-xl-5 col-xxl-4">
                        <div
                            class="authentication-login min-vh-100 bg-body row justify-content-center align-items-center p-4">
                            <div class="col-sm-8 col-md-6 col-xl-9">
                                <h2 class="mb-3 fs-7 fw-bolder">Daftar akun Photopie 🥰</h2>
                                <form action="{{ route('register') }}" method="post">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="text-name" class="form-label">Name</label>
                                        <input type="text" class="form-control @error('name')is-invalid @enderror"
                                            id="text-name" value="{{ old('name') }}" name="name" class="form-control"
                                            required>
                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="text-email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email')is-invalid @enderror"
                                            id="text-email" value="{{ old('email') }}" name="email" required>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="text-password" class="form-label">Kata Sandi</label>
                                        <input type="password" class="form-control @error('password')is-invalid @enderror"
                                            id="text-password" name="password" required minlength="6">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-4">
                                        <label for="password-confirm"
                                            class="form-label">{{ __('Konfirmasi Kata Sandi') }}</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                    <div>
                                        <button type="submit"
                                            class="btn btn-primary w-100 py-8 mb-4 rounded-2">Daftar</button>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p class="fs-4 mb-0 text-dark">Sudah punya akun?</p>
                                        <a class="text-primary fw-medium ms-2" href="{{ route('login') }}">Masuk</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
