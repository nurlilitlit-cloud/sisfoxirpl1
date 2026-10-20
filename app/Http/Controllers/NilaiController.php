<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class NilaiController extends Controller
{
    public function index()
    {
        $nilais = Nilai::with(['siswa.kelas', 'mapel'])->latest()->get();

        return view('nilai.index', compact('nilais'));
    }

    public function create()
    {
        $siswas = Siswa::with('kelas')->orderBy('nama')->get();
        $mapels = Mapel::orderBy('nama_mapel')->get();

        return view('nilai.create', compact('siswas', 'mapels'));
    }

    public function store(Request $request)
    {
        Nilai::create($this->prepareData($request));

        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil ditambahkan.');
    }

    public function edit(Nilai $nilai)
    {
        $siswas = Siswa::with('kelas')->orderBy('nama')->get();
        $mapels = Mapel::orderBy('nama_mapel')->get();

        return view('nilai.edit', compact('nilai', 'siswas', 'mapels'));
    }

    public function update(Request $request, Nilai $nilai)
    {
        $nilai->update($this->prepareData($request, $nilai));

        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil diperbarui.');
    }

    public function destroy(Nilai $nilai)
    {
        $nilai->delete();

        return redirect()->route('nilai.index')->with('success', 'Data nilai berhasil dihapus.');
    }

    /**
     * Validasi input, lalu hitung nilai akhir dan keterangan.
     * Nilai akhir = (tugas * 0.3) + (uts * 0.3) + (uas * 0.4)
     * Keterangan  = nilai akhir >= KKM mapel ? 'Lulus' : 'Tidak Lulus'
     */
    private function prepareData(Request $request, ?Nilai $nilai = null): array
    {
        $data = $request->validate([
            'siswa_id' => [
                'required',
                'exists:siswas,id',
                Rule::unique('nilais')
                    ->where(fn ($query) => $query->where('mapel_id', $request->input('mapel_id')))
                    ->ignore($nilai),
            ],
            'mapel_id' => 'required|exists:mapels,id',
            'nilai_tugas' => 'required|numeric|min:0|max:100',
            'nilai_uts' => 'required|numeric|min:0|max:100',
            'nilai_uas' => 'required|numeric|min:0|max:100',
        ]);

        $mapel = Mapel::findOrFail($data['mapel_id']);

        $data['nilai_akhir'] = round(
            ($data['nilai_tugas'] * 0.3) + ($data['nilai_uts'] * 0.3) + ($data['nilai_uas'] * 0.4),
            2
        );
        $data['keterangan'] = $data['nilai_akhir'] >= $mapel->kkm ? 'Lulus' : 'Tidak Lulus';

        return $data;
    }
}
