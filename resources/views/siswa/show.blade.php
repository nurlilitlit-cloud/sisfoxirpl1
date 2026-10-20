@extends('layouts.main')

@section('title', 'Detail Data Siswa')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-user-graduate mr-2 text-primary"></i>Detail Data Siswa</h1>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Profil Siswa</h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img class="img-fluid px-3 px-sm-4 mt-2 mb-3" style="width: 12rem;"
                            src="{{ asset('img/undraw_profile.svg') }}" alt="Profil">
                        <h5 class="font-weight-bold text-gray-800 mb-0">{{ $siswa->nama }}</h5>
                        <span class="badge badge-secondary">{{ $siswa->nis }}</span>
                    </div>
                    <table class="table table-sm table-borderless mb-0">
                        <tr><th width="38%">Kelas</th><td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td></tr>
                        <tr><th>Jenis Kelamin</th><td>{{ $siswa->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td></tr>
                        <tr><th>No HP</th><td>{{ $siswa->no_hp ?? '-' }}</td></tr>
                        <tr><th>Alamat</th><td>{{ $siswa->alamat ?? '-' }}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Nilai Mata Pelajaran</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Mata Pelajaran</th>
                                    <th class="text-center">Tugas</th>
                                    <th class="text-center">UTS</th>
                                    <th class="text-center">UAS</th>
                                    <th class="text-center">Nilai Akhir</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($siswa->nilais as $nilai)
                                    <tr>
                                        <td>{{ $nilai->mapel->nama_mapel ?? '-' }}</td>
                                        <td class="text-center">{{ $nilai->nilai_tugas + 0 }}</td>
                                        <td class="text-center">{{ $nilai->nilai_uts + 0 }}</td>
                                        <td class="text-center">{{ $nilai->nilai_uas + 0 }}</td>
                                        <td class="text-center"><span class="badge badge-info">{{ $nilai->nilai_akhir + 0 }}</span></td>
                                        <td class="text-center">
                                            <span class="badge badge-{{ $nilai->keterangan == 'Lulus' ? 'success' : 'danger' }}">{{ $nilai->keterangan }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Belum ada data nilai untuk siswa ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('siswa.index') }}" class="btn btn-secondary mb-4"><i class="fas fa-arrow-left mr-1"></i> Kembali</a>
    <a href="{{ route('siswa.edit', $siswa) }}" class="btn btn-warning mb-4"><i class="fas fa-edit mr-1"></i> Edit</a>
@endsection
