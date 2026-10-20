@extends('layouts.main')

@section('title', 'Tambah Data Kelas')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-door-open mr-2 text-primary"></i>Tambah Data Kelas</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah Kelas</h6>
        </div>
        <div class="card-body">
        <form action="{{ route('kelas.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nama_kelas">Nama Kelas <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_kelas') is-invalid @enderror" id="nama_kelas" name="nama_kelas"
                    value="{{ old('nama_kelas') }}" required placeholder="Contoh: XI RPL 1">
                @error('nama_kelas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="tingkat">Tingkat <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('tingkat') is-invalid @enderror" id="tingkat" name="tingkat"
                    value="{{ old('tingkat') }}" required placeholder="Contoh: XI">
                @error('tingkat')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="jurusan">Jurusan <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan"
                    value="{{ old('jurusan') }}" required placeholder="Contoh: Rekayasa Perangkat Lunak">
                @error('jurusan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="tahun_ajaran">Tahun Ajaran <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('tahun_ajaran') is-invalid @enderror" id="tahun_ajaran" name="tahun_ajaran"
                    value="{{ old('tahun_ajaran') }}" required placeholder="Contoh: 2025/2026">
                @error('tahun_ajaran')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Simpan</button>
            <a href="{{ route('kelas.index') }}" class="btn btn-secondary">Batal</a>
        </form>
        </div>
    </div>
@endsection
