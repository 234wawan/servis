<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\FiturLayanan;
use App\Models\Gallery;
use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KontenController extends Controller
{
    // ─── Fitur Layanan ───
    public function fiturIndex()
    {
        $fiturs = FiturLayanan::orderBy('urutan')->get();
        return view('konten.fitur_layanan.index', compact('fiturs'));
    }

    public function fiturStore(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'badge' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'urutan' => 'required|integer|min:0',
        ]);

        FiturLayanan::create($validated);

        return redirect()->route('admin.konten.fitur.index')->with('success', 'Fitur layanan berhasil ditambahkan.');
    }

    public function fiturUpdate(Request $request, FiturLayanan $fiturLayanan)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'badge' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'urutan' => 'required|integer|min:0',
        ]);

        $fiturLayanan->update($validated);

        return redirect()->route('admin.konten.fitur.index')->with('success', 'Fitur layanan berhasil diperbarui.');
    }

    public function fiturDestroy(FiturLayanan $fiturLayanan)
    {
        $fiturLayanan->delete();
        return redirect()->route('admin.konten.fitur.index')->with('success', 'Fitur layanan berhasil dihapus.');
    }

    public function fiturToggle(FiturLayanan $fiturLayanan)
    {
        $fiturLayanan->update(['is_active' => !$fiturLayanan->is_active]);
        return redirect()->route('admin.konten.fitur.index')->with('success', 'Status berhasil diubah.');
    }

    // ─── About ───
    public function aboutIndex()
    {
        $about = About::first();
        return view('konten.about.index', compact('about'));
    }

    public function aboutUpdate(Request $request)
    {
        $validated = $request->validate([
            'badge_text' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'deskripsi' => 'required|string',
            'deskripsi_2' => 'nullable|string',
            'tombol_text' => 'required|string|max:255',
            'highlights' => 'nullable|array',
            'highlights.*' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $about = About::firstOrNew();

        if ($request->hasFile('image')) {
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }
            $validated['image'] = $request->file('image')->store('abouts', 'public');
        }

        $validated['highlights'] = array_values(array_filter($request->highlights ?? []));

        $about->fill($validated);
        $about->is_active = $request->boolean('is_active', true);
        $about->save();

        return redirect()->route('admin.konten.about.index')->with('success', 'About berhasil diperbarui.');
    }

    // ─── Gallery ───
    public function galleryIndex()
    {
        $galleries = Gallery::orderBy('urutan')->get();
        return view('konten.gallery.index', compact('galleries'));
    }

    public function galleryStore(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'judul' => 'nullable|string|max:255',
            'urutan' => 'required|integer|min:0',
        ]);

        Gallery::create([
            'judul' => $request->judul,
            'image' => $request->file('image')->store('galleries', 'public'),
            'urutan' => $request->urutan,
        ]);

        return redirect()->route('admin.konten.gallery.index')->with('success', 'Galeri berhasil ditambahkan.');
    }

    public function galleryUpdate(Request $request, Gallery $gallery)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'judul' => 'nullable|string|max:255',
            'urutan' => 'required|integer|min:0',
        ]);

        $data = [
            'judul' => $request->judul,
            'urutan' => $request->urutan,
        ];

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($gallery->image);
            $data['image'] = $request->file('image')->store('galleries', 'public');
        }

        $gallery->update($data);

        return redirect()->route('admin.konten.gallery.index')->with('success', 'Galeri berhasil diperbarui.');
    }

    public function galleryDestroy(Gallery $gallery)
    {
        Storage::disk('public')->delete($gallery->image);
        $gallery->delete();
        return redirect()->route('admin.konten.gallery.index')->with('success', 'Galeri berhasil dihapus.');
    }

    public function galleryToggle(Gallery $gallery)
    {
        $gallery->update(['is_active' => !$gallery->is_active]);
        return redirect()->route('admin.konten.gallery.index')->with('success', 'Status berhasil diubah.');
    }

    // ─── Kontak ───
    public function kontakIndex()
    {
        $kontaks = Kontak::orderBy('urutan')->get();
        return view('konten.kontak.index', compact('kontaks'));
    }

    public function kontakSeed()
    {
        $data = [
            ['key' => 'no_telepon', 'label' => 'No. Telepon', 'value' => '0812-3456-7890', 'tipe' => 'telepon', 'icon' => 'bi-telephone', 'urutan' => 1],
            ['key' => 'email', 'label' => 'Email', 'value' => 'bengkelmotor@email.com', 'tipe' => 'email', 'icon' => 'bi-envelope', 'urutan' => 2],
            ['key' => 'alamat', 'label' => 'Alamat', 'value' => 'Jl. Merdeka No. 123, Jakarta', 'tipe' => 'alamat', 'icon' => 'bi-geo-alt', 'urutan' => 3],
            ['key' => 'no_wa', 'label' => 'No. WhatsApp', 'value' => '0812-3456-7890', 'tipe' => 'telepon', 'icon' => 'bi-whatsapp', 'urutan' => 4],
            ['key' => 'facebook', 'label' => 'Facebook', 'value' => '#', 'tipe' => 'sosmed', 'icon' => 'bi-facebook', 'urutan' => 5],
            ['key' => 'twitter', 'label' => 'Twitter / X', 'value' => '#', 'tipe' => 'sosmed', 'icon' => 'bi-twitter-x', 'urutan' => 6],
            ['key' => 'youtube', 'label' => 'YouTube', 'value' => '#', 'tipe' => 'sosmed', 'icon' => 'bi-youtube', 'urutan' => 7],
            ['key' => 'instagram', 'label' => 'Instagram', 'value' => '#', 'tipe' => 'sosmed', 'icon' => 'bi-instagram', 'urutan' => 8],
            ['key' => 'deskripsi_footer', 'label' => 'Deskripsi Footer', 'value' => 'Bengkel motor profesional melayani jasa perbaikan dan perawatan segala jenis dan tipe motor. Menerima jasa service online maupun datang langsung.', 'tipe' => 'teks', 'icon' => null, 'urutan' => 0],
        ];

        foreach ($data as $item) {
            Kontak::updateOrCreate(['key' => $item['key']], $item);
        }

        return redirect()->route('admin.konten.kontak.index')->with('success', 'Data kontak berhasil diinisialisasi.');
    }

    public function kontakUpdate(Request $request)
    {
        $keys = Kontak::pluck('key')->toArray();

        foreach ($keys as $key) {
            $rule = 'nullable|string';
            if ($key === 'no_telepon') $rule = 'nullable|string|max:20';
            if ($key === 'email') $rule = 'nullable|email|max:255';
        }

        $data = $request->validate([
            'kontak' => 'required|array',
            'kontak.*' => 'nullable|string|max:500',
        ]);

        foreach ($data['kontak'] as $key => $value) {
            Kontak::where('key', $key)->update(['value' => $value]);
        }

        return redirect()->route('admin.konten.kontak.index')->with('success', 'Kontak berhasil diperbarui.');
    }
}
