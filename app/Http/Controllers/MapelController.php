<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MapelController extends Controller
{
    public function index()
    {
        $mapels = Mapel::orderBy('nama_mapel')->get();

        return view('mapel.index', compact('mapels'));
    }

    public function create()
    {
        return view('mapel.create');
    }

    public function store(Request $request)
    {
        Mapel::create($this->validateData($request));

        return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran berhasil ditambahkan.');
    }

    public function edit(Mapel $mapel)
    {
        return view('mapel.edit', compact('mapel'));
    }

    public function update(Request $request, Mapel $mapel)
    {
        $mapel->update($this->validateData($request, $mapel));

        // KKM berubah -> keterangan nilai yang sudah ada ikut diperbarui
        foreach ($mapel->nilais as $nilai) {
            $nilai->update(['keterangan' => $nilai->nilai_akhir >= $mapel->kkm ? 'Lulus' : 'Tidak Lulus']);
        }

        return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran berhasil diperbarui.');
    }

    public function destroy(Mapel $mapel)
    {
        if ($mapel->nilais()->exists()) {
            return redirect()->route('mapel.index')
                ->with('error', 'Mata pelajaran "'.$mapel->nama_mapel.'" tidak dapat dihapus karena sudah memiliki data nilai.');
        }

        $mapel->delete();

        return redirect()->route('mapel.index')->with('success', 'Data mata pelajaran berhasil dihapus.');
    }

    private function validateData(Request $request, ?Mapel $mapel = null): array
    {
        return $request->validate([
            'kode_mapel' => ['required', 'string', 'max:255', Rule::unique('mapels', 'kode_mapel')->ignore($mapel)],
            'nama_mapel' => 'required|string|max:255',
            'kkm' => 'required|integer|min:0|max:100',
        ]);
    }
}
