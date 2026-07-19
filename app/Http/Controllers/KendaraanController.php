<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraans = Kendaraan::with('pelanggan')->latest()->get();
        return view('kendaraan.index', compact('kendaraans'));
    }

    public function create()
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        return view('kendaraan.create', compact('pelanggans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'no_polisi' => 'required|string|max:15|unique:kendaraans,no_polisi',
            'merek' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'tahun' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'warna' => 'nullable|string|max:30',
        ]);

        Kendaraan::create($validated);

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    public function show(Kendaraan $kendaraan)
    {
        $kendaraan->load('pelanggan', 'servis');
        return view('kendaraan.show', compact('kendaraan'));
    }

    public function edit(Kendaraan $kendaraan)
    {
        $pelanggans = Pelanggan::orderBy('nama')->get();
        return view('kendaraan.edit', compact('kendaraan', 'pelanggans'));
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'no_polisi' => 'required|string|max:15|unique:kendaraans,no_polisi,' . $kendaraan->id,
            'merek' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'tahun' => 'nullable|integer|min:1900|max:' . (date('Y') + 1),
            'warna' => 'nullable|string|max:30',
        ]);

        $kendaraan->update($validated);

        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil diperbarui.');
    }

    public function destroy(Kendaraan $kendaraan)
    {
        $kendaraan->delete();
        return redirect()->route('admin.kendaraan.index')->with('success', 'Kendaraan berhasil dihapus.');
    }
}
