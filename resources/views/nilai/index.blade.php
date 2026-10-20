@extends('layouts.main')

@section('title', 'Nilai Siswa')

@section('content')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-star mr-2 text-primary"></i>Nilai Akademik Siswa</h1>
        <a href="{{ route('nilai.create') }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Input Nilai Siswa
        </a>
    </div>

    <!-- DataTales -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Rekapitulasi Nilai Siswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Siswa</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Tugas (30%)</th>
                            <th>UTS (30%)</th>
                            <th>UAS (40%)</th>
                            <th>Nilai Akhir</th>
                            <th>Status</th>
                            <th class="text-center no-sort" width="14%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nilais as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $item->siswa->nama ?? '-' }}</td>
                                <td>{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                                <td>{{ $item->mapel->nama_mapel ?? '-' }}</td>
                                <td class="text-center">{{ $item->nilai_tugas + 0 }}</td>
                                <td class="text-center">{{ $item->nilai_uts + 0 }}</td>
                                <td class="text-center">{{ $item->nilai_uas + 0 }}</td>
                                <td class="text-center"><span class="badge badge-info">{{ $item->nilai_akhir + 0 }}</span></td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $item->keterangan == 'Lulus' ? 'success' : 'danger' }}">
                                        {{ $item->keterangan }}
                                    </span>
                                </td>
                            <td class="text-center text-nowrap">
                                <a href="{{ route('nilai.edit', $item) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('nilai.destroy', $item) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus nilai ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
