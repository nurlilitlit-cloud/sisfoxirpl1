@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('content')
<div class="container">

    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">

        <div class="col-xl-6 col-lg-8 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="p-5">
                        <div class="text-center mb-4">
                            <h1 class="h4 text-gray-900 font-weight-bold">Verifikasi Alamat Email Anda</h1>
                            <p class="text-muted small"></p>
                        </div>

                        @if (session('resent'))
                            <div class="alert alert-success small" role="alert">Tautan verifikasi baru telah dikirim ke alamat email Anda.</div>
                        @endif

                        <p class="small text-center">Sebelum melanjutkan, silakan periksa email Anda untuk tautan verifikasi.</p>
                        <form class="d-block text-center" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-user btn-block font-weight-bold shadow-sm">
                                Kirim Ulang Email Verifikasi
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
