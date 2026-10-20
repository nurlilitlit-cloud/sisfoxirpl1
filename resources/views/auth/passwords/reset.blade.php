@extends('layouts.app')

@section('title', 'Reset Kata Sandi')

@section('content')
<div class="container">

    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">

        <div class="col-xl-6 col-lg-8 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center mb-4">
                            <h1 class="h4 text-gray-900 font-weight-bold">Setel Ulang Kata Sandi</h1>
                            <p class="text-muted small">Masukkan kata sandi baru Anda.</p>
                        </div>

                        <form class="user" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Alamat Email">
                                @error('email')
                                    <span class="invalid-feedback ml-3" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                    id="password" name="password" required autocomplete="new-password" placeholder="Kata Sandi Baru">
                                @error('password')
                                    <span class="invalid-feedback ml-3" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="password-confirm"
                                    name="password_confirmation" required autocomplete="new-password" placeholder="Ulangi Kata Sandi Baru">
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block font-weight-bold shadow-sm">
                                Reset Kata Sandi
                            </button>
                        </form>

                        <hr>

                        <div class="text-center">
                            <a class="small font-weight-bold" href="{{ route('login') }}">Kembali ke Halaman Login</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
@endsection
