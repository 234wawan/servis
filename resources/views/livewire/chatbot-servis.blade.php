<div class="d-flex flex-column flex-grow-1" style="min-height: 0;">
    <button id="btn-reset-chat" wire:click="resetChat" class="d-none"></button>

    {{-- Chat Area --}}
    <div class="flex-grow-1 p-3 bg-light chat-scroll d-flex flex-column gap-3 overflow-y-auto" x-ref="chatbox" x-init="$nextTick(() => $el.scrollTop = $el.scrollHeight)">
        @foreach ($messages as $msg)
            <div class="d-flex {{ $msg['from'] === 'user' ? 'justify-content-end' : 'justify-content-start' }} align-items-end gap-2 bounce-in" style="max-width: 90%; {{ $msg['from'] === 'user' ? 'align-self: flex-end;' : 'align-self: flex-start;' }}">
                @if ($msg['from'] === 'bot')
                    <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 26px; height: 26px; background: #0f2a44;">
                        <i class="bi bi-person text-white" style="font-size: 0.6rem;"></i>
                    </div>
                @endif
                <div>
                    <div class="px-3 py-2 shadow-sm" style="font-size: 0.8rem; line-height: 1.4; {{ $msg['from'] === 'user' ? 'background: #0f2a44; color: white; border-radius: 14px 14px 4px 14px;' : 'background: white; color: #334155; border-radius: 14px 14px 14px 4px; border: 1px solid #e2e8f0;' }}">
                        @if ($msg['from'] === 'bot')
                            {!! $msg['text'] !!}
                        @else
                            {{ $msg['text'] }}
                        @endif
                    </div>
                    <small class="d-block mt-1 px-1" style="font-size: 0.55rem; color: #94a3b8;">{{ $msg['time'] }}</small>
                </div>
            </div>
        @endforeach

        {{-- Existing Kendaraan Buttons --}}
        @if ($showExistingKendaraan)
            <div class="d-flex align-items-end gap-2 bounce-in" style="max-width: 95%; align-self: flex-start;">
                <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 26px; height: 26px; background: #0f2a44;">
                    <i class="bi bi-person text-white" style="font-size: 0.6rem;"></i>
                </div>
                <div class="bg-white border shadow-sm p-2" style="border-radius: 14px 14px 14px 4px; border-color: #e2e8f0 !important;">
                    <div class="d-flex flex-column gap-1.5">
                        @foreach ($kendaraanOptions as $k)
                            <button wire:click="selectExistingKendaraan({{ $k['id'] }})" class="btn btn-sm btn-outline-secondary text-start d-flex flex-column px-2 py-1.5" style="border-color: #e2e8f0; font-size: 0.75rem; border-radius: 8px;">
                                <span class="fw-semibold">{{ $k['no_polisi'] }}</span>
                                <small class="text-secondary">{{ $k['merek'] }} {{ $k['model'] }} ({{ $k['tahun'] }})</small>
                            </button>
                        @endforeach
                        <button wire:click="newKendaraan" class="btn btn-sm btn-outline-primary border-dashed text-center px-2 py-1.5" style="font-size: 0.75rem; border-radius: 8px;">
                            + Motor baru
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Paket Selection --}}
        @if ($step === 12 && $pakets->isNotEmpty() && !$paketSelected && !$submitted)
            <div class="d-flex align-items-end gap-2 bounce-in" style="max-width: 95%; align-self: flex-start;">
                <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 26px; height: 26px; background: #0f2a44;">
                    <i class="bi bi-person text-white" style="font-size: 0.6rem;"></i>
                </div>
                <div class="bg-white border shadow-sm p-2" style="border-radius: 14px 14px 14px 4px; border-color: #e2e8f0 !important;">
                    <small class="text-secondary d-block mb-1.5" style="font-size: 0.75rem;">Pilih paket servis:</small>
                    <div class="d-flex flex-column gap-1.5">
                        @foreach ($pakets as $paket)
                            <button wire:click="selectPaket({{ $paket->id }})" class="btn btn-sm btn-outline-secondary text-start d-flex justify-content-between align-items-center gap-1 px-2 py-1.5" style="border-color: #e2e8f0; font-size: 0.75rem; border-radius: 8px;">
                                <span class="fw-semibold small text-truncate">{{ $paket->nama_paket }}</span>
                                <span class="fw-bold text-primary flex-shrink-0" style="font-size: 0.7rem;">Rp{{ number_format($paket->biaya, 0, ',', '.') }}</span>
                            </button>
                        @endforeach
                        <button wire:click="selectPaket(0)" class="btn btn-sm btn-outline-secondary border-dashed text-center px-2 py-1.5" style="font-size: 0.75rem; border-radius: 8px;">
                            Lewati
                        </button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Confirm Existing Kendaraan --}}
        @if ($step === 3 && !empty($kendaraanOptions))
            <div class="d-flex align-items-end gap-2 bounce-in" style="max-width: 95%; align-self: flex-start;">
                <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 26px; height: 26px; background: #0f2a44;">
                    <i class="bi bi-person text-white" style="font-size: 0.6rem;"></i>
                </div>
                <div class="bg-white border shadow-sm p-2" style="border-radius: 14px 14px 14px 4px; border-color: #e2e8f0 !important;">
                    <div class="d-flex flex-wrap gap-1.5">
                        <button wire:click="confirmYes" class="btn btn-sm px-3 text-white border-0 fw-semibold" style="background-color: #0f2a44; font-size: 0.75rem; border-radius: 8px;">Ya, terdaftar</button>
                        <button wire:click="confirmNo" class="btn btn-sm btn-outline-secondary px-3" style="font-size: 0.75rem; border-radius: 8px;">Motor baru</button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Final Confirmation --}}
        @if ($paketSelected && !$submitted)
            <div class="d-flex align-items-end gap-2 bounce-in" style="max-width: 95%; align-self: flex-start;">
                <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 26px; height: 26px; background: #0f2a44;">
                    <i class="bi bi-person text-white" style="font-size: 0.6rem;"></i>
                </div>
                <div class="bg-white border shadow-sm p-2" style="border-radius: 14px 14px 14px 4px; border-color: #e2e8f0 !important;">
                    <div class="d-flex flex-wrap gap-1.5">
                        <button wire:click="confirmYes" class="btn btn-sm px-3 text-white border-0 fw-semibold" style="background-color: #0f2a44; font-size: 0.75rem; border-radius: 8px;">Ya, daftarkan!</button>
                        <button wire:click="confirmNo" class="btn btn-sm btn-outline-secondary px-3" style="font-size: 0.75rem; border-radius: 8px;">Ulangi</button>
                    </div>
                </div>
            </div>
        @endif

        {{-- Typing Indicator --}}
        @if ($typing)
            <div class="d-flex align-items-end gap-2" style="align-self: flex-start;">
                <div class="d-flex align-items-center justify-content-center rounded-circle flex-shrink-0" style="width: 26px; height: 26px; background: #0f2a44;">
                    <i class="bi bi-person text-white" style="font-size: 0.6rem;"></i>
                </div>
                <div class="bg-white border shadow-sm px-3 py-2.5 d-flex gap-1" style="border-radius: 14px 14px 14px 4px; border-color: #e2e8f0 !important;">
                    <span class="typing-dot rounded-circle d-inline-block bg-secondary" style="width: 6px; height: 6px;"></span>
                    <span class="typing-dot rounded-circle d-inline-block bg-secondary" style="width: 6px; height: 6px;"></span>
                    <span class="typing-dot rounded-circle d-inline-block bg-secondary" style="width: 6px; height: 6px;"></span>
                </div>
            </div>
        @endif
    </div>

    {{-- Input Bar --}}
    <div class="border-top bg-white px-3 py-2 flex-shrink-0">
        <form wire:submit.prevent="sendMessage" class="d-flex gap-2 align-items-center">
            <input type="text" wire:model="inputBuffer" placeholder="Ketik pesan..." class="form-control form-control-sm border-0 bg-light px-3 py-2" style="border-radius: 20px; font-size: 0.8rem;" autocomplete="off">
            <button type="submit" class="btn d-flex align-items-center justify-content-center text-white border-0 flex-shrink-0 p-0" style="background-color: #0f2a44; width: 34px; height: 34px; border-radius: 50%; min-width: 34px;">
                <i class="bi bi-send" style="font-size: 0.7rem;"></i>
            </button>
        </form>
    </div>
</div>
