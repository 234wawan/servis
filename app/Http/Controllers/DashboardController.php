<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\Kendaraan;
use App\Models\Servis;
use App\Models\Sparepart;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalPelanggan = Pelanggan::count();
        $totalKendaraan = Kendaraan::count();
        $totalServis = Servis::count();
        $servisPending = Servis::where('status', 'pending')->where('is_void', false)->count();
        $servisProses = Servis::where('status', 'proses')->where('is_void', false)->count();
        $servisSelesai = Servis::where('status', 'selesai')->where('is_void', false)->count();
        $servisDiambil = Servis::where('status', 'diambil')->where('is_void', false)->count();
        $totalPendapatan = Servis::whereIn('status', ['selesai', 'diambil'])->where('is_void', false)->sum('total_bayar');
        $totalUsers = User::count();
        $totalSparepart = Sparepart::count();
        $stokMenipis = Sparepart::whereRaw('stok <= stok_minimum')->count();

        $pendapatanHarian = Servis::whereIn('status', ['selesai', 'diambil'])->where('is_void', false)
            ->whereDate('tgl_pembayaran', today())
            ->sum('total_bayar');

        $pendapatanBulanan = Servis::whereIn('status', ['selesai', 'diambil'])->where('is_void', false)
            ->whereYear('tgl_pembayaran', date('Y'))
            ->whereMonth('tgl_pembayaran', date('m'))
            ->sum('total_bayar');

        $servisTerbaru = Servis::with('kendaraan.pelanggan', 'voidedBy')
            ->latest()
            ->take(5)
            ->get();

        $chartPendapatan = Servis::whereIn('status', ['selesai', 'diambil'])->where('is_void', false)
            ->select(
                DB::raw('MONTH(tgl_pembayaran) as bulan'),
                DB::raw('SUM(total_bayar) as total')
            )
            ->whereYear('tgl_pembayaran', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $chartServis = Servis::whereYear('created_at', date('Y'))
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        return view('dashboard.index', compact(
            'totalPelanggan', 'totalKendaraan', 'totalServis',
            'servisPending', 'servisProses', 'servisSelesai', 'servisDiambil',
            'totalPendapatan', 'servisTerbaru',
            'totalUsers', 'totalSparepart', 'stokMenipis',
            'pendapatanHarian', 'pendapatanBulanan',
            'chartPendapatan', 'chartServis'
        ));
    }
}
