@extends('layouts.app')

@section('title', 'Konfirmasi Kata Sandi')

@section('content')
<div class="container">

    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">

        <div class="col-xl-6 col-lg-8 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center mb-4">
                            <h1 class="h4 text-gray-900 font-weight-bold">Konfirmasi Kata Sandi</h1>
                            <p class="text-muted small">Mohon konfirmasi kata sandi Anda sebelum melanjutkan.</p>
                        </div>

                        <form class="user" method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <div class="form-group">
                                <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror"
                                    id="password" name="password" required autocomplete="current-password" placeholder="Kata Sandi">
                                @error('password')
                                    <span class="invalid-feedback ml-3" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block font-weight-bold shadow-sm">
                                Konfirmasi Kata Sandi
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
