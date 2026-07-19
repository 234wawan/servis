<?php

namespace App\Http\Controllers;

use App\Models\MasterServis;
use App\Models\Servis;
use App\Models\Kendaraan;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServisController extends Controller
{
    public function index(Request $request)
    {
        $query = Servis::with('kendaraan.pelanggan', 'voidedBy', 'spareparts');

        if ($request->filled('status')) {
            if ($request->status === 'void') {
                $query->where('is_void', true);
            } else {
                $query->where('status', $request->status)->where('is_void', false);
            }
        } else {
            $query->where('is_void', false);
        }

        $servis = $query->latest()->get();
        $statusFilter = $request->get('status', '');

        return view('servis.index', compact('servis', 'statusFilter'));
    }

    public function create()
    {
        $kendaraans = Kendaraan::with('pelanggan')->orderBy('no_polisi')->get();
        $masterServis = MasterServis::orderBy('nama_paket')->get();
        $spareparts = Sparepart::with('kategori')->orderBy('nama_sparepart')->get();
        return view('servis.create', compact('kendaraans', 'masterServis', 'spareparts'));
    }

    public function store(Request $request)
    {
        $request->merge(['biaya' => str_replace('.', '', $request->biaya)]);

        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tipe_barang' => 'nullable|string|max:50',
            'tgl_masuk' => 'required|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_masuk',
            'keluhan' => 'required|string',
            'kelengkapan' => 'nullable|string',
            'catatan' => 'nullable|string',
            'biaya' => 'required|numeric|min:0',
            'paket_biaya' => 'nullable|numeric|min:0',
            'master_servis_id' => 'nullable|exists:master_servis,id',
            'status' => 'required|in:pending,proses,selesai,diambil',
            'spareparts' => 'nullable|array',
            'spareparts.*.id' => 'required|exists:spareparts,id',
            'spareparts.*.qty' => 'required|integer|min:1',
        ]);

        $validated['biaya'] = ($validated['paket_biaya'] ?? 0) + $validated['biaya'];
        $validated['master_servis_id'] = !empty($validated['master_servis_id']) ? $validated['master_servis_id'] : null;
        $validated['no_antrian'] = $this->generateAntrian();
        $validated['diskon'] = 0;
        $validated['total_bayar'] = $validated['biaya'];

        $servis = DB::transaction(function () use ($validated, $request) {
            $servis = Servis::create($validated);
            $sparepartSubtotal = $this->syncSpareparts($servis, $request->input('spareparts', []));
            $servis->update(['total_bayar' => $servis->biaya + $sparepartSubtotal]);
            return $servis;
        });

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'id' => $servis->id,
                'no_antrian' => $servis->no_antrian,
                'redirect' => route('admin.servis.show', $servis),
            ]);
        }

        return redirect()->route('admin.servis.show', $servis)->with('success', "Servis berhasil ditambahkan. No. Antrian: {$servis->no_antrian}");
    }

    public function show(Servis $servis)
    {
        $servis->load('kendaraan.pelanggan', 'voidedBy', 'spareparts');
        return view('servis.show', compact('servis'));
    }

    public function edit(Servis $servis)
    {
        if ($servis->is_void) {
            return redirect()->route('admin.servis.index')->with('error', 'Servis yang sudah di-void tidak dapat diedit.');
        }

        $servis->load('spareparts');
        $kendaraans = Kendaraan::with('pelanggan')->orderBy('no_polisi')->get();
        $masterServis = MasterServis::orderBy('nama_paket')->get();
        $spareparts = Sparepart::with('kategori')->orderBy('nama_sparepart')->get();
        return view('servis.edit', compact('servis', 'kendaraans', 'masterServis', 'spareparts'));
    }

    public function update(Request $request, Servis $servis)
    {
        if ($servis->is_void) {
            return redirect()->route('admin.servis.index')->with('error', 'Servis yang sudah di-void tidak dapat diedit.');
        }

        $request->merge(['biaya' => str_replace('.', '', $request->biaya)]);

        $validated = $request->validate([
            'kendaraan_id' => 'required|exists:kendaraans,id',
            'tipe_barang' => 'nullable|string|max:50',
            'tgl_masuk' => 'required|date',
            'tgl_selesai' => 'nullable|date|after_or_equal:tgl_masuk',
            'keluhan' => 'required|string',
            'kelengkapan' => 'nullable|string',
            'catatan' => 'nullable|string',
            'biaya' => 'required|numeric|min:0',
            'paket_biaya' => 'nullable|numeric|min:0',
            'master_servis_id' => 'nullable|exists:master_servis,id',
            'status' => 'required|in:pending,proses,selesai,diambil',
            'spareparts' => 'nullable|array',
            'spareparts.*.id' => 'required|exists:spareparts,id',
            'spareparts.*.qty' => 'required|integer|min:1',
        ]);

        $validated['biaya'] = ($validated['paket_biaya'] ?? 0) + $validated['biaya'];
        $validated['master_servis_id'] = !empty($validated['master_servis_id']) ? $validated['master_servis_id'] : null;

        DB::transaction(function () use ($request, $validated, $servis) {
            $servis->update($validated);
            $sparepartSubtotal = $this->syncSpareparts($servis, $request->input('spareparts', []));
            $servis->update(['total_bayar' => $servis->biaya + $sparepartSubtotal]);
        });

        return redirect()->route('admin.servis.index')->with('success', 'Servis berhasil diperbarui.');
    }

    public function destroy(Servis $servis)
    {
        if ($servis->status !== 'pending') {
            return redirect()->route('admin.servis.index')->with('error', 'Hanya servis dengan status pending yang dapat dihapus.');
        }

        DB::transaction(function () use ($servis) {
            $servis->load('spareparts');
            foreach ($servis->spareparts as $sp) {
                $sp->increment('stok', $sp->pivot->qty);
            }
            $servis->spareparts()->detach();
            $servis->delete();
        });

        return redirect()->route('admin.servis.index')->with('success', 'Servis berhasil dihapus.');
    }

    public function void(Request $request, Servis $servis)
    {
        if ($servis->is_void) {
            return redirect()->route('admin.servis.index')->with('error', 'Servis ini sudah di-void sebelumnya.');
        }

        $validated = $request->validate([
            'alasan_void' => 'required|string',
        ]);

        $servis->update([
            'is_void' => true,
            'voided_by' => auth()->id(),
            'voided_at' => now(),
            'alasan_void' => $validated['alasan_void'],
        ]);

        return redirect()->route('admin.servis.index')->with('success', 'Servis berhasil di-void.');
    }

    public function checkout(Servis $servis)
    {
        if ($servis->is_void) {
            return redirect()->route('admin.servis.index')->with('error', 'Servis sudah di-void.');
        }
        if ($servis->status !== 'selesai') {
            return redirect()->route('admin.servis.index')->with('error', 'Servis harus selesai terlebih dahulu sebelum checkout.');
        }
        if ($servis->metode_pembayaran) {
            return redirect()->route('admin.servis.index')->with('error', 'Servis ini sudah dibayar.');
        }

        $servis->load('kendaraan.pelanggan', 'spareparts');
        return view('servis.checkout', compact('servis'));
    }

    public function bayar(Request $request, Servis $servis)
    {
        if ($servis->is_void) {
            return redirect()->route('admin.servis.index')->with('error', 'Servis sudah di-void.');
        }
        if ($servis->status !== 'selesai') {
            return redirect()->route('admin.servis.index')->with('error', 'Servis harus selesai terlebih dahulu.');
        }
        if ($servis->metode_pembayaran) {
            return redirect()->route('admin.servis.index')->with('error', 'Servis ini sudah dibayar.');
        }

        $servis->load('spareparts');
        $sparepartSubtotal = $servis->spareparts->sum(fn($s) => $s->pivot->subtotal);

        $request->merge([
            'biaya' => str_replace('.', '', $request->biaya),
            'diskon' => str_replace('.', '', $request->diskon),
        ]);

        $validated = $request->validate([
            'biaya' => 'required|numeric|min:0',
            'tipe_diskon' => 'nullable|in:nominal,persen',
            'diskon' => 'nullable|numeric|min:0',
            'metode_pembayaran' => 'required|in:tunai,transfer,qris',
        ]);

        $biaya = $validated['biaya'];
        $diskon = $validated['diskon'] ?? 0;
        $tipeDiskon = $validated['tipe_diskon'] ?? null;

        if ($tipeDiskon === 'persen') {
            $diskonRupiah = ($biaya + $sparepartSubtotal) * ($diskon / 100);
        } elseif ($tipeDiskon === 'nominal') {
            $diskonRupiah = $diskon;
        } else {
            $diskonRupiah = 0;
            $diskon = 0;
        }

        $totalBayar = max(0, $biaya + $sparepartSubtotal - $diskonRupiah);

        $servis->update([
            'biaya' => $biaya,
            'tipe_diskon' => $tipeDiskon,
            'diskon' => $diskon,
            'total_bayar' => $totalBayar,
            'metode_pembayaran' => $validated['metode_pembayaran'],
            'tgl_pembayaran' => now(),
            'status' => 'diambil',
        ]);

        return redirect()->route('admin.servis.struk', $servis)->with('success', 'Pembayaran berhasil!');
    }

    public function struk(Servis $servis)
    {
        $servis->load('kendaraan.pelanggan', 'voidedBy', 'spareparts');
        return view('servis.struk', compact('servis'));
    }

    public function nota(Servis $servis)
    {
        $servis->load('kendaraan.pelanggan', 'spareparts');
        return view('servis.nota', compact('servis'));
    }

    public function updateStatus(Request $request, Servis $servis)
    {
        if ($servis->is_void) {
            return response()->json(['error' => 'Servis sudah di-void'], 400);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,proses,selesai,diambil',
        ]);

        if ($validated['status'] === 'selesai') {
            $validated['tgl_selesai'] = now()->format('Y-m-d');
        }

        $servis->update($validated);

        return response()->json(['success' => true, 'status' => $servis->status]);
    }

    public function storeMasterServis(Request $request)
    {
        $request->merge(['biaya' => str_replace('.', '', $request->biaya)]);
        $validated = $request->validate([
            'nama_paket' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'biaya' => 'required|numeric|min:0',
        ]);

        $paket = MasterServis::create($validated);

        return response()->json([
            'id' => $paket->id,
            'nama_paket' => $paket->nama_paket,
            'biaya' => $paket->biaya,
            'keterangan' => $paket->keterangan,
        ]);
    }

    private function syncSpareparts(Servis $servis, array $items): float
    {
        $oldParts = $servis->spareparts()->get()->keyBy('id');
        $newIds = collect($items)->pluck('id')->toArray();

        foreach ($oldParts as $old) {
            if (!in_array($old->id, $newIds)) {
                $old->increment('stok', $old->pivot->qty);
            }
        }

        $syncData = [];
        $totalSubtotal = 0;

        foreach ($items as $item) {
            $sparepart = Sparepart::findOrFail($item['id']);
            $qty = (int) $item['qty'];
            $oldQty = $oldParts->has($sparepart->id) ? $oldParts[$sparepart->id]->pivot->qty : 0;
            $diff = $qty - $oldQty;

            if ($diff > 0 && $sparepart->stok < $diff) {
                throw new \Exception("Stok {$sparepart->nama_sparepart} tidak mencukupi. Tersedia: {$sparepart->stok}, dibutuhkan: {$diff}");
            }

            if ($diff > 0) {
                $sparepart->decrement('stok', $diff);
            } elseif ($diff < 0) {
                $sparepart->increment('stok', abs($diff));
            }

            $subtotal = $qty * $sparepart->harga_jual;
            $syncData[$sparepart->id] = [
                'qty' => $qty,
                'harga_jual' => $sparepart->harga_jual,
                'subtotal' => $subtotal,
            ];
            $totalSubtotal += $subtotal;
        }

        $servis->spareparts()->sync($syncData);
        return $totalSubtotal;
    }

    private function generateAntrian(): string
    {
        $date = now()->format('Ymd');
        $last = Servis::whereDate('created_at', today())
            ->whereNotNull('no_antrian')
            ->orderBy('no_antrian', 'desc')
            ->first();

        if ($last && preg_match('/SRV-(\d+)-(\d+)/', $last->no_antrian, $m)) {
            $next = (int) $m[2] + 1;
        } else {
            $next = 1;
        }

        return 'SRV-' . $date . '-' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}
