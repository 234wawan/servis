<?php

namespace App\Http\Controllers;

use App\Models\MasterServis;
use Illuminate\Http\Request;

class MasterServisController extends Controller
{
    public function index()
    {
        $masterServis = MasterServis::latest()->get();
        return view('master_servis.index', compact('masterServis'));
    }

    public function create()
    {
        return redirect()->route('admin.master-servis.index');
    }

    public function store(Request $request)
    {
        $request->merge(['biaya' => str_replace('.', '', $request->biaya)]);
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'biaya' => 'required|numeric|min:0',
        ]);

        $paket = MasterServis::create($validated);

        if ($request->wantsJson()) {
            return response()->json($paket);
        }

        return redirect()->route('admin.master-servis.index')->with('success', 'Paket servis berhasil ditambahkan.');
    }

    public function edit(MasterServis $master_servi)
    {
        return redirect()->route('admin.master-servis.index');
    }

    public function update(Request $request, MasterServis $master_servi)
    {
        $request->merge(['biaya' => str_replace('.', '', $request->biaya)]);
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'biaya' => 'required|numeric|min:0',
        ]);

        $master_servi->update($validated);

        if ($request->wantsJson()) {
            return response()->json($master_servi);
        }

        return redirect()->route('admin.master-servis.index')->with('success', 'Paket servis berhasil diperbarui.');
    }

    public function destroy(Request $request, MasterServis $master_servi)
    {
        $master_servi->delete();

        if ($request->wantsJson()) {
            return response()->json(['ok' => true]);
        }

        return redirect()->route('admin.master-servis.index')->with('success', 'Paket servis berhasil dihapus.');
    }
}
