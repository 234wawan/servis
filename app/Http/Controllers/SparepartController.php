<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use App\Models\Sparepart;
use Illuminate\Http\Request;

class SparepartController extends Controller
{
    public function index()
    {
        $spareparts = Sparepart::with('kategori')->latest()->get();
        return view('sparepart.index', compact('spareparts'));
    }

    public function create()
    {
        $kategoris = KategoriBarang::orderBy('nama_kategori')->get();
        return view('sparepart.create', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'harga_beli' => str_replace('.', '', $request->harga_beli),
            'harga_jual' => str_replace('.', '', $request->harga_jual),
        ]);

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_barangs,id',
            'kode_sparepart' => 'required|string|max:50|unique:spareparts,kode_sparepart',
            'nama_sparepart' => 'required|string|max:255',
            'satuan' => 'required|string|max:20',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        Sparepart::create($validated);

        return redirect()->route('admin.sparepart.index')->with('success', 'Sparepart berhasil ditambahkan.');
    }

    public function show(Sparepart $sparepart)
    {
        $sparepart->load('kategori');
        return view('sparepart.show', compact('sparepart'));
    }

    public function edit(Sparepart $sparepart)
    {
        $kategoris = KategoriBarang::orderBy('nama_kategori')->get();
        return view('sparepart.edit', compact('sparepart', 'kategoris'));
    }

    public function update(Request $request, Sparepart $sparepart)
    {
        $request->merge([
            'harga_beli' => str_replace('.', '', $request->harga_beli),
            'harga_jual' => str_replace('.', '', $request->harga_jual),
        ]);

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategori_barangs,id',
            'kode_sparepart' => 'required|string|max:50|unique:spareparts,kode_sparepart,' . $sparepart->id,
            'nama_sparepart' => 'required|string|max:255',
            'satuan' => 'required|string|max:20',
            'stok' => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $sparepart->update($validated);

        return redirect()->route('admin.sparepart.index')->with('success', 'Sparepart berhasil diperbarui.');
    }

    public function destroy(Sparepart $sparepart)
    {
        $sparepart->delete();
        return redirect()->route('admin.sparepart.index')->with('success', 'Sparepart berhasil dihapus.');
    }
}
