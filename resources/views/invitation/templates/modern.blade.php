<x-layouts.pin>
    <div class="min-h-screen bg-rose-50 flex flex-col items-center justify-center px-4 py-12">
        <div class="bg-white rounded-3xl shadow-sm w-full max-w-sm overflow-hidden">
            <div class="px-8 py-10 text-center" style="background: linear-gradient(135deg, #fda4af, #f9a8d4)">
                <p class="text-white/70 text-xs tracking-widest uppercase mb-3">You Are Invited</p>
                <h1 class="text-white text-2xl font-medium">{{ $event->nama_event }}</h1>
                <p class="text-white/70 text-sm mt-2">{{ $event->tanggal->format('d F Y') }}</p>
                @if($event->lokasi)
                    <p class="text-white/70 text-sm">{{ $event->lokasi }}</p>
                @endif
            </div>
            <div class="px-8 py-6 text-center border-b border-rose-50">
                <p class="text-xs text-rose-300 uppercase tracking-widest mb-1">Kepada Yth.</p>
                <p class="text-lg font-medium text-gray-800">{{ $guest->nama_utama }}</p>
                <p class="text-sm text-rose-300 mt-1">{{ $guest->jumlah_tamu }} tamu</p>
            </div>
            <div class="px-8 py-8 flex flex-col items-center">
                <p class="text-xs text-rose-300 uppercase tracking-widest mb-4">Tunjukkan QR ini saat hadir</p>
                <div class="p-3 bg-white border border-rose-100 rounded-2xl">
                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(180)->format('svg')->color(253, 164, 175)->generate($guest->qr_code) !!}
                </div>
                <p class="text-xs text-rose-200 mt-4">#{{ $guest->nomor_undangan ?? substr($guest->qr_code, 0, 8) }}</p>
            </div>
            @if($guest->status !== 'terdaftar')
                <div class="mx-8 mb-8 bg-rose-50 border border-rose-100 rounded-2xl px-4 py-3 text-center">
                    <p class="text-rose-500 text-sm font-medium">✓ Sudah check-in</p>
                </div>
            @endif
        </div>
        <p class="text-rose-200 text-xs mt-8">Powered by GuestBook Digital</p>
    </div>
</x-layouts.pin>