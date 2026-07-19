<?php

namespace App\Http\Controllers;

use App\Models\Servis;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function keuangan(Request $request)
    {
        $period = $request->get('period', 'bulanan');
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $query = Servis::where('status', 'selesai')->where('is_void', false);

        if ($period === 'harian') {
            $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->get('end_date', now()->format('Y-m-d'));
            $query->whereBetween('tgl_selesai', [$startDate, $endDate]);
            $pendapatan = $query->sum('biaya');
            $servisList = $query->with('kendaraan.pelanggan')->orderBy('tgl_selesai')->get();
            $totalServis = $servisList->count();
        } else {
            $query->whereYear('tgl_selesai', $year)->whereMonth('tgl_selesai', $month);
            $pendapatan = $query->sum('biaya');
            $servisList = $query->with('kendaraan.pelanggan')->orderBy('tgl_selesai')->get();
            $totalServis = $servisList->count();
        }

        $pendapatanBulanan = Servis::where('status', 'selesai')->where('is_void', false)
            ->select(DB::raw('YEAR(tgl_selesai) as tahun, MONTH(tgl_selesai) as bulan, SUM(biaya) as total'))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->take(12)
            ->get();

        return view('laporan.keuangan', compact(
            'pendapatan', 'totalServis', 'servisList',
            'period', 'year', 'month', 'pendapatanBulanan'
        ));
    }

    public function performa(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $servisSelesai = Servis::where('status', 'selesai')
            ->where('is_void', false)
            ->whereYear('tgl_selesai', $year)
            ->whereMonth('tgl_selesai', $month)
            ->get();

        $totalServis = $servisSelesai->count();
        $rataHari = 0;

        if ($totalServis > 0) {
            $totalHari = $servisSelesai->sum(function ($s) {
                if ($s->tgl_masuk && $s->tgl_selesai) {
                    return \Carbon\Carbon::parse($s->tgl_masuk)->diffInDays(\Carbon\Carbon::parse($s->tgl_selesai));
                }
                return 0;
            });
            $rataHari = $totalHari / $totalServis;
        }

        $servisPerBulan = Servis::where('status', 'selesai')->where('is_void', false)
            ->select(DB::raw('YEAR(tgl_selesai) as tahun, MONTH(tgl_selesai) as bulan, COUNT(*) as total'))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'desc')
            ->orderBy('bulan', 'desc')
            ->take(12)
            ->get();

        return view('laporan.performa', compact(
            'totalServis', 'rataHari', 'year', 'month', 'servisPerBulan'
        ));
    }

    public function stok()
    {
        $spareparts = Sparepart::with('kategori')
            ->whereRaw('stok <= stok_minimum')
            ->orderBy('stok')
            ->get();

        return view('laporan.stok', compact('spareparts'));
    }

    public function exportKeuangan(Request $request)
    {
        $period = $request->get('period', 'bulanan');
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $query = Servis::where('status', 'selesai')->where('is_void', false);

        if ($period === 'harian') {
            $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->get('end_date', now()->format('Y-m-d'));
            $query->whereBetween('tgl_selesai', [$startDate, $endDate]);
        } else {
            $query->whereYear('tgl_selesai', $year)->whereMonth('tgl_selesai', $month);
        }

        $servisList = $query->with('kendaraan.pelanggan')->orderBy('tgl_selesai')->get();

        $filename = 'laporan-keuangan-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($servisList) {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($output, ['No', 'No Polisi', 'Pemilik', 'Tgl Masuk', 'Tgl Selesai', 'Keluhan', 'Biaya']);

            foreach ($servisList as $i => $s) {
                fputcsv($output, [
                    $i + 1,
                    $s->kendaraan->no_polisi ?? '-',
                    $s->kendaraan->pelanggan->nama ?? '-',
                    $s->tgl_masuk,
                    $s->tgl_selesai,
                    $s->keluhan,
                    $s->biaya,
                ]);
            }

            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPerforma(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $servisList = Servis::where('status', 'selesai')
            ->where('is_void', false)
            ->whereYear('tgl_selesai', $year)
            ->whereMonth('tgl_selesai', $month)
            ->with('kendaraan.pelanggan')
            ->orderBy('tgl_selesai')
            ->get();

        $filename = 'laporan-performa-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($servisList) {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($output, ['No', 'No Polisi', 'Pemilik', 'Tgl Masuk', 'Tgl Selesai', 'Durasi (Hari)']);

            foreach ($servisList as $i => $s) {
                $durasi = $s->tgl_masuk && $s->tgl_selesai
                    ? \Carbon\Carbon::parse($s->tgl_masuk)->diffInDays(\Carbon\Carbon::parse($s->tgl_selesai))
                    : 0;

                fputcsv($output, [
                    $i + 1,
                    $s->kendaraan->no_polisi ?? '-',
                    $s->kendaraan->pelanggan->nama ?? '-',
                    $s->tgl_masuk,
                    $s->tgl_selesai,
                    $durasi,
                ]);
            }

            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportStok()
    {
        $spareparts = Sparepart::with('kategori')
            ->whereRaw('stok <= stok_minimum')
            ->orderBy('stok')
            ->get();

        $filename = 'laporan-stok-menipis-' . date('Y-m-d') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($spareparts) {
            $output = fopen('php://output', 'w');
            fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($output, ['No', 'Kode', 'Nama Sparepart', 'Kategori', 'Stok', 'Stok Minimum', 'Status']);

            foreach ($spareparts as $i => $s) {
                fputcsv($output, [
                    $i + 1,
                    $s->kode_sparepart,
                    $s->nama_sparepart,
                    $s->kategori->nama_kategori ?? '-',
                    $s->stok,
                    $s->stok_minimum,
                    $s->stok == 0 ? 'Habis' : 'Menipis',
                ]);
            }

            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdfKeuangan(Request $request)
    {
        $period = $request->get('period', 'bulanan');
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $query = Servis::where('status', 'selesai')->where('is_void', false);

        if ($period === 'harian') {
            $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
            $endDate = $request->get('end_date', now()->format('Y-m-d'));
            $query->whereBetween('tgl_selesai', [$startDate, $endDate]);
        } else {
            $query->whereYear('tgl_selesai', $year)->whereMonth('tgl_selesai', $month);
        }

        $servisList = $query->with('kendaraan.pelanggan')->orderBy('tgl_selesai')->get();
        $pendapatan = $servisList->sum('biaya');
        $totalServis = $servisList->count();

        $html = view('laporan.pdf_keuangan', compact('servisList', 'pendapatan', 'totalServis', 'period'))->render();

        $pdf = new \Dompdf\Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return $pdf->stream('laporan-keuangan-' . date('Y-m-d') . '.pdf');
    }

    public function exportPdfPerforma(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $month = $request->get('month', date('m'));

        $servisList = Servis::where('status', 'selesai')
            ->where('is_void', false)
            ->whereYear('tgl_selesai', $year)
            ->whereMonth('tgl_selesai', $month)
            ->with('kendaraan.pelanggan')
            ->orderBy('tgl_selesai')
            ->get();

        $totalServis = $servisList->count();
        $rataHari = 0;
        if ($totalServis > 0) {
            $totalHari = $servisList->sum(function ($s) {
                if ($s->tgl_masuk && $s->tgl_selesai) {
                    return \Carbon\Carbon::parse($s->tgl_masuk)->diffInDays(\Carbon\Carbon::parse($s->tgl_selesai));
                }
                return 0;
            });
            $rataHari = $totalHari / $totalServis;
        }

        $html = view('laporan.pdf_performa', compact('servisList', 'totalServis', 'rataHari', 'year', 'month'))->render();

        $pdf = new \Dompdf\Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();

        return $pdf->stream('laporan-performa-' . date('Y-m-d') . '.pdf');
    }
}
