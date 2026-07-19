<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    public function index()
    {
        $kategoris = KategoriBarang::withCount('spareparts')->latest()->get();
        return view('kategori_barang.index', compact('kategoris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriBarang::create($validated);

        return redirect()->route('admin.kategori-barang.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, KategoriBarang $kategoriBarang)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategoriBarang->update($validated);

        return redirect()->route('admin.kategori-barang.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(KategoriBarang $kategoriBarang)
    {
        if ($kategoriBarang->spareparts()->count() > 0) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki sparepart.');
        }

        $kategoriBarang->delete();
        return redirect()->route('admin.kategori-barang.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
