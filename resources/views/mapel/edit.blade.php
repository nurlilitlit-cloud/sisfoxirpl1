@extends('layouts.main')

@section('title', 'Edit Mata Pelajaran')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-book mr-2 text-primary"></i>Edit Mata Pelajaran</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Mata Pelajaran</h6>
        </div>
        <div class="card-body">
        <form action="{{ route('mapel.update', $mapel) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="kode_mapel">Kode Mapel <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('kode_mapel') is-invalid @enderror" id="kode_mapel" name="kode_mapel"
                    value="{{ old('kode_mapel', $mapel->kode_mapel) }}" required placeholder="Contoh: MP-PWPB">
                @error('kode_mapel')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="nama_mapel">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('nama_mapel') is-invalid @enderror" id="nama_mapel" name="nama_mapel"
                    value="{{ old('nama_mapel', $mapel->nama_mapel) }}" required >
                @error('nama_mapel')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="kkm">KKM <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('kkm') is-invalid @enderror" id="kkm" name="kkm"
                    value="{{ old('kkm', $mapel->kkm) }}" required min="0" max="100" >
                @error('kkm')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Perbarui</button>
            <a href="{{ route('mapel.index') }}" class="btn btn-secondary">Batal</a>
        </form>
        </div>
    </div>
@endsection
