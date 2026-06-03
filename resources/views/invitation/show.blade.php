<x-layouts.pin>
    <div class="min-h-screen bg-stone-50 flex flex-col items-center justify-center px-4 py-12">

        {{-- Card undangan --}}
        <div class="bg-white rounded-3xl shadow-sm border border-stone-100 w-full max-w-sm overflow-hidden">

            {{-- Header dekoratif --}}
            <div class="bg-stone-800 px-8 py-10 text-center">
                <p class="text-stone-400 text-xs tracking-widest uppercase mb-3">Undangan Pernikahan</p>
                <h1 class="text-white text-2xl font-medium">{{ $event->nama_event }}</h1>
                <p class="text-stone-400 text-sm mt-2">{{ $event->tanggal->format('d F Y') }}</p>
                @if($event->lokasi)
                    <p class="text-stone-400 text-sm">{{ $event->lokasi }}</p>
                @endif
            </div>

            {{-- Nama tamu --}}
            <div class="px-8 py-6 text-center border-b border-stone-100">
                <p class="text-xs text-stone-400 uppercase tracking-widest mb-1">Kepada Yth.</p>
                <p class="text-lg font-medium text-stone-800">{{ $guest->nama_utama }}</p>
                <p class="text-sm text-stone-400 mt-1">{{ $guest->jumlah_tamu }} tamu</p>
            </div>

            {{-- QR Code --}}
            <div class="px-8 py-8 flex flex-col items-center">
                <p class="text-xs text-stone-400 uppercase tracking-widest mb-4">Tunjukkan QR ini saat hadir</p>
                <div class="p-3 bg-white border border-stone-200 rounded-2xl">
                    {!! QrCode::size(180)
                        ->format('svg')
                        ->generate($guest->qr_code) !!}
                </div>
                <p class="text-xs text-stone-300 mt-4">#{{ $guest->nomor_undangan ?? $guest->qr_code }}</p>
            </div>

            {{-- Status --}}
            @if($guest->status !== 'terdaftar')
                <div class="mx-8 mb-8 bg-green-50 border border-green-100 rounded-2xl px-4 py-3 text-center">
                    <p class="text-green-700 text-sm font-medium">✓ Sudah check-in</p>
                </div>
            @endif

        </div>

        <p class="text-stone-300 text-xs mt-8">Powered by GuestBook Digital</p>
    </div>
</x-layouts.pin>