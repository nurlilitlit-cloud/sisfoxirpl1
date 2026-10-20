<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::withCount('siswas')->orderBy('nama_kelas')->get();

        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        return view('kelas.create');
    }

    public function store(Request $request)
    {
        Kelas::create($this->validateData($request));

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kela)
    {
        return view('kelas.edit', ['kelas' => $kela]);
    }

    public function update(Request $request, Kelas $kela)
    {
        $kela->update($this->validateData($request));

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        if ($kela->siswas()->exists()) {
            return redirect()->route('kelas.index')
                ->with('error', 'Kelas "'.$kela->nama_kelas.'" tidak dapat dihapus karena masih memiliki siswa.');
        }

        $kela->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'tingkat' => 'required|string|max:10',
            'jurusan' => 'required|string|max:255',
            'tahun_ajaran' => 'required|string|max:20',
        ]);
    }
}
