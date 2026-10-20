<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GuruController extends Controller
{
    public function index()
    {
        $gurus = Guru::orderBy('nama')->get();

        return view('guru.index', compact('gurus'));
    }

    public function create()
    {
        return view('guru.create');
    }

    public function store(Request $request)
    {
        Guru::create($this->validateData($request));

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $guru->update($this->validateData($request, $guru));

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }

    private function validateData(Request $request, ?Guru $guru = null): array
    {
        return $request->validate([
            'nip' => ['required', 'string', 'max:255', Rule::unique('gurus', 'nip')->ignore($guru)],
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'email' => 'nullable|email|max:255',
            'no_hp' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',
        ]);
    }
}
