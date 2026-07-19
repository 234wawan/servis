<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\KontenController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MasterServisController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\ServisController;
use App\Http\Controllers\SparepartController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ─── Customer Frontend (Public) ───
Route::get('/', function () {
    $pakets = App\Models\MasterServis::orderBy('biaya')->get();
    $fiturs = App\Models\FiturLayanan::where('is_active', true)->orderBy('urutan')->get();
    $about = App\Models\About::where('is_active', true)->first();
    $galleries = App\Models\Gallery::where('is_active', true)->orderBy('urutan')->get();
    $kontaks = App\Models\Kontak::where('is_active', true)->orderBy('urutan')->get();
    return view('customer.index', compact('pakets', 'fiturs', 'about', 'galleries', 'kontaks'));
})->name('home');

Route::redirect('/servis/daftar', '/')->name('customer.chatbot');

Route::get('/servis/cek', function () {
    return view('customer.cek-status');
})->name('customer.cek-status');

Route::get('/kontak', function () {
    $kontaks = App\Models\Kontak::where('is_active', true)->orderBy('urutan')->get();
    $sosmeds = $kontaks->where('tipe', 'sosmed');
    return view('customer.kontak', compact('kontaks', 'sosmeds'));
})->name('customer.kontak');

// ─── Admin Backend ───
Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [LoginController::class, 'login'])->name('login');
        Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
        Route::post('/register', [RegisterController::class, 'register'])->name('register');
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

    Route::middleware('auth')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('pelanggan', PelangganController::class);
        Route::resource('kendaraan', KendaraanController::class);

        // ─── Servis: Kasir & Admin ───
        Route::get('/servis', [ServisController::class, 'index'])->name('servis.index');
        Route::get('/servis/create', [ServisController::class, 'create'])->name('servis.create');
        Route::post('/servis', [ServisController::class, 'store'])->name('servis.store');
        Route::get('/servis/{servis}', [ServisController::class, 'show'])->name('servis.show');
        Route::get('/servis/{servis}/checkout', [ServisController::class, 'checkout'])->name('servis.checkout');
        Route::post('/servis/{servis}/bayar', [ServisController::class, 'bayar'])->name('servis.bayar');
        Route::get('/servis/{servis}/struk', [ServisController::class, 'struk'])->name('servis.struk');
        Route::get('/servis/{servis}/nota', [ServisController::class, 'nota'])->name('servis.nota');
        Route::post('/servis/{servis}/update-status', [ServisController::class, 'updateStatus'])->name('servis.update-status');

        Route::prefix('laporan')->name('laporan.')->group(function () {
            Route::get('/keuangan', [LaporanController::class, 'keuangan'])->name('keuangan');
            Route::get('/keuangan/export', [LaporanController::class, 'exportKeuangan'])->name('keuangan.export');
            Route::get('/keuangan/pdf', [LaporanController::class, 'exportPdfKeuangan'])->name('keuangan.pdf');
        });

        // ─── Admin Only ───
        Route::middleware('role:admin')->group(function () {
            Route::get('/servis/{servis}/edit', [ServisController::class, 'edit'])->name('servis.edit');
            Route::put('/servis/{servis}', [ServisController::class, 'update'])->name('servis.update');
            Route::delete('/servis/{servis}', [ServisController::class, 'destroy'])->name('servis.destroy');
            Route::post('/servis/{servis}/void', [ServisController::class, 'void'])->name('servis.void');

            Route::post('/master-servis/quick', [ServisController::class, 'storeMasterServis'])->name('master-servis.quick');
            Route::resource('master-servis', MasterServisController::class)->except(['show']);

            Route::resource('kategori-barang', KategoriBarangController::class)->except(['create', 'show', 'edit']);
            Route::resource('sparepart', SparepartController::class);

            Route::prefix('laporan')->name('laporan.')->group(function () {
                Route::get('/performa', [LaporanController::class, 'performa'])->name('performa');
                Route::get('/performa/export', [LaporanController::class, 'exportPerforma'])->name('performa.export');
                Route::get('/performa/pdf', [LaporanController::class, 'exportPdfPerforma'])->name('performa.pdf');
                Route::get('/stok', [LaporanController::class, 'stok'])->name('stok');
                Route::get('/stok/export', [LaporanController::class, 'exportStok'])->name('stok.export');
            });

            Route::resource('users', UserController::class);
            Route::post('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');

            // ─── Kelola Konten Website ───
            Route::prefix('konten')->name('konten.')->group(function () {
                Route::get('/fitur-layanan', [KontenController::class, 'fiturIndex'])->name('fitur.index');
                Route::post('/fitur-layanan', [KontenController::class, 'fiturStore'])->name('fitur.store');
                Route::put('/fitur-layanan/{fiturLayanan}', [KontenController::class, 'fiturUpdate'])->name('fitur.update');
                Route::delete('/fitur-layanan/{fiturLayanan}', [KontenController::class, 'fiturDestroy'])->name('fitur.destroy');
                Route::post('/fitur-layanan/{fiturLayanan}/toggle', [KontenController::class, 'fiturToggle'])->name('fitur.toggle');

                Route::get('/about', [KontenController::class, 'aboutIndex'])->name('about.index');
                Route::post('/about', [KontenController::class, 'aboutUpdate'])->name('about.update');

                Route::get('/gallery', [KontenController::class, 'galleryIndex'])->name('gallery.index');
                Route::post('/gallery', [KontenController::class, 'galleryStore'])->name('gallery.store');
                Route::post('/gallery/{gallery}', [KontenController::class, 'galleryUpdate'])->name('gallery.update');
                Route::delete('/gallery/{gallery}', [KontenController::class, 'galleryDestroy'])->name('gallery.destroy');
                Route::post('/gallery/{gallery}/toggle', [KontenController::class, 'galleryToggle'])->name('gallery.toggle');

                Route::get('/kontak', [KontenController::class, 'kontakIndex'])->name('kontak.index');
                Route::post('/kontak', [KontenController::class, 'kontakUpdate'])->name('kontak.update');
                Route::post('/kontak/seed', [KontenController::class, 'kontakSeed'])->name('kontak.seed');
            });
        });
    });
});
