<?php

namespace App\Livewire;

use App\Models\Kendaraan;
use App\Models\MasterServis;
use App\Models\Pelanggan;
use App\Models\Servis;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class ChatbotServis extends Component
{
    public int $step = 0;
    public array $messages = [];
    public bool $typing = false;

    public string $nama = '';
    public string $no_wa = '';
    public string $no_polisi = '';
    public string $merek = '';
    public string $model = '';
    public string $tahun = '';
    public string $warna = '';
    public string $keluhan = '';
    public ?int $selectedPaket = null;
    public string $inputBuffer = '';
    public bool $paketSelected = false;

    public bool $submitted = false;
    public ?int $preselectPaketId = null;

    public ?int $existingPelangganId = null;
    public ?int $existingKendaraanId = null;

    public ?Pelanggan $foundPelanggan = null;
    public array $kendaraanOptions = [];
    public bool $useExistingKendaraan = false;

    #[On('preSelectPaket')]
    public function setPreselectPaket($paketId): void
    {
        $this->preselectPaketId = (int) $paketId;
    }

    public function mount(): void
    {
        $this->addMessage('bot', 'Halo! 👋 Selamat datang di <b>Bengkel Motor</b>');
        $this->addMessage('bot', 'Saya akan membantu Anda mendaftarkan servis dengan mudah. Silakan masukkan <b>nama Anda</b>:');

        $this->step = 1;
    }

    public function sendMessage(): void
    {
        $input = trim($this->inputBuffer);
        if (empty($input)) return;

        $this->addMessage('user', $input);
        $this->inputBuffer = '';
        $this->typing = true;

        try {
            $this->processStep($input);
        } catch (\Exception $e) {
            $this->addMessage('bot', 'Maaf, terjadi kesalahan: ' . $e->getMessage());
            $this->addMessage('bot', 'Silakan coba lagi.');
        }

        $this->typing = false;
    }

    public function selectPaket(int $id): void
    {
        $this->typing = true;
        if ($id === 0) {
            $this->addMessage('user', 'Lewati (tanpa paket)');
            $this->selectedPaket = null;
        } else {
            $this->addMessage('user', MasterServis::find($id)?->nama_paket ?? 'Paket #' . $id);
            $this->selectedPaket = $id;
        }
        $this->paketSelected = true;
        $this->showConfirmation();
        $this->typing = false;
    }

    public function confirmYes(): void
    {
        if ($this->submitted) return;
        $this->addMessage('user', 'Ya, lanjutkan');
        $this->typing = true;
        $this->processYes();
        $this->typing = false;
    }

    public function confirmNo(): void
    {
        $this->addMessage('user', 'Tidak, ulangi');
        $this->typing = true;
        $this->step = 1;
        $this->nama = '';
        $this->no_wa = '';
        $this->no_polisi = '';
        $this->merek = '';
        $this->model = '';
        $this->tahun = '';
        $this->warna = '';
        $this->keluhan = '';
        $this->selectedPaket = null;
        $this->existingPelangganId = null;
        $this->existingKendaraanId = null;
        $this->foundPelanggan = null;
        $this->kendaraanOptions = [];
        $this->useExistingKendaraan = false;
        $this->paketSelected = false;
        $this->submitted = false;
        $this->preselectPaketId = null;
        $this->addMessage('bot', 'Baik, mari mulai dari awal. Silakan masukkan <b>nama Anda</b>:');
        $this->typing = false;
    }

    public function selectExistingKendaraan(int $id): void
    {
        $this->typing = true;
        $this->existingKendaraanId = $id;
        $k = Kendaraan::find($id);
        $this->addMessage('user', $k->no_polisi . ' (' . $k->merek . ' ' . $k->model . ')');
        $this->step = 6;
        $this->addMessage('bot', 'Apa <b>keluhan</b> atau masalah pada motor Anda?');
        $this->typing = false;
    }

    public function newKendaraan(): void
    {
        $this->addMessage('user', 'Motor baru');
        $this->typing = true;
        $this->useExistingKendaraan = false;
        $this->step = 5;
        $this->addMessage('bot', 'Silakan masukkan <b>nomor polisi</b> motor Anda (contoh: B 1234 ABC):');
        $this->typing = false;
    }

    private function processStep(string $input): void
    {
        match ($this->step) {
            1 => $this->handleNama($input),
            2 => $this->handleNoWa($input),
            3 => $this->handleExistingPelanggan($input),
            4 => $this->handleKendaraanChoice($input),
            5 => $this->handleNoPolisi($input),
            6 => $this->handleNoPolisiInput($input),
            7 => $this->handleMerek($input),
            8 => $this->handleModel($input),
            9 => $this->handleTahun($input),
            10 => $this->handleWarna($input),
            11 => $this->handleKeluhan($input),
            default => $this->addMessage('bot', 'Silakan ikuti petunjuk di atas.'),
        };
    }

    private function handleNama(string $input): void
    {
        if (strlen($input) < 2) {
            $this->addMessage('bot', 'Nama terlalu pendek. Silakan masukkan nama lengkap Anda:');
            return;
        }
        $this->nama = $input;
        $this->step = 2;
        $this->addMessage('bot', 'Senang bertemu Anda, <b>' . e($this->nama) . '</b>! 🎉');
        $this->addMessage('bot', 'Masukkan <b>nomor WhatsApp</b> Anda (contoh: 08123456789):');
    }

    private function handleNoWa(string $input): void
    {
        $digits = preg_replace('/[^0-9]/', '', $input);
        if (strlen($digits) < 10) {
            $this->addMessage('bot', 'Nomor WhatsApp tidak valid. Masukkan minimal 10 angka:');
            return;
        }
        $this->no_wa = $digits;

        $this->foundPelanggan = Pelanggan::where('no_wa', $digits)->first();

        if ($this->foundPelanggan) {
            $this->existingPelangganId = $this->foundPelanggan->id;
            $this->kendaraanOptions = $this->foundPelanggan->kendaraans->toArray();
            $this->step = 3;
            $msg = 'Saya menemukan data Anda, <b>' . e($this->foundPelanggan->nama) . '</b>! 🙌';

            if (!empty($this->kendaraanOptions)) {
                $msg .= '<br><br>Motor yang pernah terdaftar:';
                foreach ($this->kendaraanOptions as $k) {
                    $msg .= '<br>• ' . e($k['no_polisi']) . ' — ' . e($k['merek']) . ' ' . e($k['model']);
                }
                $msg .= '<br><br>Apakah motor Anda sudah terdaftar di atas?';
            } else {
                $msg .= '<br><br>Belum ada motor yang terdaftar. Silakan daftarkan motor baru.';
                $this->step = 5;
                $msg .= '<br><br>Silakan masukkan <b>nomor polisi</b> motor Anda:';
            }
            $this->addMessage('bot', $msg);
        } else {
            $this->step = 5;
            $this->addMessage('bot', 'Data tidak ditemukan. Silakan daftarkan motor Anda.');
            $this->addMessage('bot', 'Masukkan <b>nomor polisi</b> motor Anda (contoh: B 1234 ABC):');
        }
    }

    private function handleExistingPelanggan(string $input): void
    {
        $lower = strtolower(trim($input));
        if (in_array($lower, ['ya', 'y', 'iya', 'yes', 'sudah', 'ada'])) {
            $this->step = 4;
            $msg = 'Silakan pilih motor yang akan diservis:';
            $this->addMessage('bot', $msg);
        } else {
            $this->useExistingKendaraan = false;
            $this->step = 5;
            $this->addMessage('bot', 'Silakan masukkan <b>nomor polisi</b> motor baru Anda (contoh: B 1234 ABC):');
        }
    }

    private function handleKendaraanChoice(string $input): void
    {
        $this->useExistingKendaraan = false;
        $this->step = 5;
        $this->addMessage('bot', 'Silakan masukkan <b>nomor polisi</b> motor Anda (contoh: B 1234 ABC):');
    }

    private function handleNoPolisi(string $input): void
    {
        $this->handleNoPolisiInput($input);
    }

    private function handleNoPolisiInput(string $input): void
    {
        if (empty($input)) {
            $this->addMessage('bot', 'Nomor polisi tidak boleh kosong. Silakan masukkan:');
            return;
        }
        $this->no_polisi = strtoupper($input);
        $this->step = 7;
        $this->addMessage('bot', 'Masukkan <b>merek</b> motor (contoh: Honda, Yamaha, Suzuki):');
    }

    private function handleMerek(string $input): void
    {
        if (strlen($input) < 2) {
            $this->addMessage('bot', 'Merek tidak valid. Silakan masukkan merek motor:');
            return;
        }
        $this->merek = ucwords($input);
        $this->step = 8;
        $this->addMessage('bot', 'Masukkan <b>model</b> motor (contoh: Vario 125, NMAX, Beat):');
    }

    private function handleModel(string $input): void
    {
        if (strlen($input) < 2) {
            $this->addMessage('bot', 'Model tidak valid. Silakan masukkan model motor:');
            return;
        }
        $this->model = ucwords($input);
        $this->step = 9;
        $this->addMessage('bot', 'Masukkan <b>tahun</b> pembuatan motor (contoh: 2020):');
    }

    private function handleTahun(string $input): void
    {
        $tahun = (int) $input;
        $thnSekarang = (int) date('Y');
        if ($tahun < 2000 || $tahun > ($thnSekarang + 1)) {
            $this->addMessage('bot', 'Tahun tidak valid. Masukkan tahun antara 2000 - ' . $thnSekarang . ':');
            return;
        }
        $this->tahun = (string) $tahun;
        $this->step = 10;
        $this->addMessage('bot', 'Masukkan <b>warna</b> motor (contoh: Merah, Hitam, Biru):');
    }

    private function handleWarna(string $input): void
    {
        if (strlen($input) < 2) {
            $this->addMessage('bot', 'Warna tidak valid. Silakan masukkan warna motor:');
            return;
        }
        $this->warna = ucwords($input);
        $this->step = 11;
        $this->addMessage('bot', 'Apa <b>keluhan</b> atau masalah pada motor Anda?');
        $this->addMessage('bot', 'Contoh: "Oli bocor", "Ban botak", "Mesin brebet", dll.');
    }

    private function handleKeluhan(string $input): void
    {
        if (strlen($input) < 3) {
            $this->addMessage('bot', 'Keluhan terlalu pendek. Jelaskan masalah motor Anda:');
            return;
        }
        $this->keluhan = $input;
        $this->step = 12;

        $pakets = MasterServis::orderBy('nama_paket')->get();

        $msg = 'Terima kasih! Berikut <b>paket servis</b> yang tersedia:';

        $this->addMessage('bot', $msg);

        if ($pakets->isEmpty()) {
            $this->addMessage('bot', '(Belum ada paket servis tersedia. Servis akan dicatat tanpa paket.)');
            $this->selectedPaket = null;
            $this->showConfirmation();
        } elseif ($this->preselectPaketId && $pakets->contains('id', $this->preselectPaketId)) {
            $this->selectPaket($this->preselectPaketId);
            $this->preselectPaketId = null;
        }
    }

    private function processYes(): void
    {
        if ($this->step === 3 && !empty($this->kendaraanOptions)) {
            $this->step = 4;
            $msg = 'Silakan pilih motor yang akan diservis:';
            $this->addMessage('bot', $msg);
            return;
        }

        if ($this->step === 12) {
            $this->submitServis();
        }
    }

    public function showConfirmation(): void
    {
        $pelanggan = $this->foundPelanggan;
        $namaTampil = $pelanggan ? $pelanggan->nama : $this->nama;

        $msg = 'Baik, berikut ringkasan data Anda:';
        $msg .= '<br><br>━━━━━━━━━━━━━━━━━';
        $msg .= '<br>👤 <b>Nama:</b> ' . e($namaTampil);
        $msg .= '<br>📱 <b>WA:</b> ' . e($this->no_wa);
        $msg .= '<br>━━━━━━━━━━━━━━━━━';
        $msg .= '<br>🏍️ <b>Motor:</b> ' . e($this->no_polisi);
        $msg .= '<br>🔧 <b>Merek:</b> ' . e($this->merek);
        $msg .= '<br>📋 <b>Model:</b> ' . e($this->model);
        $msg .= '<br>📅 <b>Tahun:</b> ' . e($this->tahun);
        $msg .= '<br>🎨 <b>Warna:</b> ' . e($this->warna);
        $msg .= '<br>━━━━━━━━━━━━━━━━━';
        $msg .= '<br>💬 <b>Keluhan:</b> ' . e($this->keluhan);

        if ($this->selectedPaket) {
            $paket = MasterServis::find($this->selectedPaket);
            if ($paket) {
                $msg .= '<br>📦 <b>Paket:</b> ' . e($paket->nama_paket) . ' (Rp ' . number_format($paket->biaya, 0, ',', '.') . ')';
            }
        }

        $msg .= '<br>━━━━━━━━━━━━━━━━━';
        $msg .= '<br><br>Apakah data di atas sudah benar?';

        $this->addMessage('bot', $msg);
    }

    public function submitServis(): void
    {
        $this->typing = true;

        try {
            DB::transaction(function () {
                if ($this->existingPelangganId) {
                    $pelanggan = Pelanggan::find($this->existingPelangganId);
                } else {
                    $pelanggan = Pelanggan::create([
                        'nama' => $this->nama,
                        'no_wa' => $this->no_wa,
                        'no_telp' => $this->no_wa,
                        'alamat' => '',
                    ]);
                    $this->existingPelangganId = $pelanggan->id;
                }

                if ($this->existingKendaraanId) {
                    $kendaraan = Kendaraan::find($this->existingKendaraanId);
                } else {
                    $kendaraan = Kendaraan::create([
                        'pelanggan_id' => $this->existingPelangganId,
                        'no_polisi' => $this->no_polisi,
                        'merek' => $this->merek,
                        'model' => $this->model,
                        'tahun' => $this->tahun,
                        'warna' => $this->warna,
                    ]);
                }

                $biayaPaket = 0;
                if ($this->selectedPaket) {
                    $paket = MasterServis::find($this->selectedPaket);
                    $biayaPaket = $paket?->biaya ?? 0;
                }

                $antrian = $this->generateAntrian();

                $servis = Servis::create([
                    'kendaraan_id' => $kendaraan->id,
                    'master_servis_id' => $this->selectedPaket,
                    'tgl_masuk' => now()->format('Y-m-d'),
                    'keluhan' => $this->keluhan,
                    'biaya' => $biayaPaket,
                    'total_bayar' => $biayaPaket,
                    'status' => 'pending',
                    'no_antrian' => $antrian,
                    'is_void' => false,
                    'diskon' => 0,
                ]);

                $msg = '🎉 <b>Selamat Anda sudah terdaftar!</b>';
                $msg .= '<br><br>🔢 <b style="font-size:1.3em">No. Antrian: ' . e($antrian) . '</b>';
                $msg .= '<br><br>Silakan datang ke bengkel kami dan tunjukkan nomor antrian ini.';
                $msg .= '<br><br>Anda bisa <a href="' . route('customer.cek-status') . '?q=' . e($antrian) . '" style="color:#818cf8;text-decoration:underline;"><b>cek status servis</b></a> secara online.';

                $this->addMessage('bot', $msg);
            });
        } catch (\Exception $e) {
            $this->addMessage('bot', 'Maaf, terjadi kesalahan saat mendaftarkan servis: ' . $e->getMessage());
            $this->addMessage('bot', 'Silakan coba lagi nanti atau hubungi bengkel langsung.');
        }

        $this->submitted = true;
        $this->paketSelected = false;
        $this->typing = false;
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

    private function addMessage(string $from, string $text): void
    {
        $this->messages[] = [
            'from' => $from,
            'text' => $text,
            'time' => now()->format('H:i'),
        ];
    }

    public function resetChat(): void
    {
        $this->step = 0;
        $this->messages = [];
        $this->nama = '';
        $this->no_wa = '';
        $this->no_polisi = '';
        $this->merek = '';
        $this->model = '';
        $this->tahun = '';
        $this->warna = '';
        $this->keluhan = '';
        $this->selectedPaket = null;
        $this->inputBuffer = '';
        $this->paketSelected = false;
        $this->submitted = false;
        $this->existingPelangganId = null;
        $this->existingKendaraanId = null;
        $this->foundPelanggan = null;
        $this->kendaraanOptions = [];
        $this->useExistingKendaraan = false;
        $this->addMessage('bot', 'Halo! 👋 Selamat datang di <b>Bengkel Motor</b>');
        $this->addMessage('bot', 'Saya akan membantu Anda mendaftarkan servis dengan mudah. Silakan masukkan <b>nama Anda</b>:');
        $this->step = 1;
    }

    public function render()
    {
        $pakets = $this->step === 12 ? MasterServis::orderBy('nama_paket')->get() : collect();

        return view('livewire.chatbot-servis', [
            'pakets' => $pakets,
            'showExistingKendaraan' => $this->step === 4 && !empty($this->kendaraanOptions),
        ]);
    }
}
