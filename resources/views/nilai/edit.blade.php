@extends('layouts.main')

@section('title', 'Edit Nilai Siswa')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-star mr-2 text-primary"></i>Edit Nilai Siswa</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Form Edit Nilai</h6>
        </div>
        <div class="card-body">
        <form action="{{ route('nilai.update', $nilai) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="siswa_id">Pilih Siswa <span class="text-danger">*</span></label>
                <select class="form-control @error('siswa_id') is-invalid @enderror" id="siswa_id" name="siswa_id" required>
                    <option value="">-- Pilih Siswa --</option>
                    @foreach ($siswas as $s)
                        <option value="{{ $s->id }}" {{ (string) old('siswa_id', $nilai->siswa_id) === (string) $s->id ? 'selected' : '' }}>{{ $s->nama }} ({{ $s->nis }}) - {{ $s->kelas->nama_kelas ?? '-' }}</option>
                    @endforeach
                </select>
                @error('siswa_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="mapel_id">Pilih Mata Pelajaran <span class="text-danger">*</span></label>
                <select class="form-control @error('mapel_id') is-invalid @enderror" id="mapel_id" name="mapel_id" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>
                    @foreach ($mapels as $m)
                        <option value="{{ $m->id }}" {{ (string) old('mapel_id', $nilai->mapel_id) === (string) $m->id ? 'selected' : '' }}>{{ $m->nama_mapel }} (KKM {{ $m->kkm }})</option>
                    @endforeach
                </select>
                @error('mapel_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="nilai_tugas">Nilai Tugas (30%) <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('nilai_tugas') is-invalid @enderror" id="nilai_tugas" name="nilai_tugas"
                    value="{{ old('nilai_tugas', $nilai->nilai_tugas + 0) }}" required min="0" max="100" step="0.01" >
                @error('nilai_tugas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="nilai_uts">Nilai UTS (30%) <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('nilai_uts') is-invalid @enderror" id="nilai_uts" name="nilai_uts"
                    value="{{ old('nilai_uts', $nilai->nilai_uts + 0) }}" required min="0" max="100" step="0.01" >
                @error('nilai_uts')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="nilai_uas">Nilai UAS (40%) <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('nilai_uas') is-invalid @enderror" id="nilai_uas" name="nilai_uas"
                    value="{{ old('nilai_uas', $nilai->nilai_uas + 0) }}" required min="0" max="100" step="0.01" >
                @error('nilai_uas')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <p class="small text-muted mb-0">Nilai akhir dihitung otomatis: (Tugas &times; 30%) + (UTS &times; 30%) + (UAS &times; 40%). Keterangan ditentukan dari KKM mata pelajaran.</p>

            <hr>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Perbarui</button>
            <a href="{{ route('nilai.index') }}" class="btn btn-secondary">Batal</a>
        </form>
        </div>
    </div>
@endsection
