<x-layouts.pin>
    <div class="min-h-screen bg-gray-50 p-6">
        <div class="max-w-2xl mx-auto">

            {{-- Header --}}
            <div class="mb-6">
                <h1 class="text-xl font-medium text-gray-800">{{ $event->nama_event }}</h1>
                <p class="text-sm text-gray-500">{{ $event->tanggal->format('d F Y') }} · {{ $event->lokasi }}</p>
            </div>

            {{-- Alert --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Search --}}
            <form method="GET" action="{{ route('receptionist.index', $event) }}" class="mb-6">
                <div class="flex gap-2">
                    <input
                        type="text"
                        name="search"
                        value="{{ $query }}"
                        placeholder="Cari nama tamu..."
                        autofocus
                        class="flex-1 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300"
                    />
                    <button type="submit" class="bg-gray-800 text-white rounded-xl px-5 py-3 text-sm font-medium hover:bg-gray-700 transition">
                        Cari
                    </button>
                </div>
            </form>

            {{-- Tombol scan QR --}}
            <div class="mb-4 flex gap-2">
                <button onclick="openScanner()"
                    class="flex items-center gap-2 border border-gray-200 text-gray-700 rounded-xl px-4 py-2.5 text-sm font-medium hover:bg-gray-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                    </svg>
                    Scan QR
                </button>
            </div>

            {{-- Modal scanner --}}
            <div id="scanner-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-2xl p-6 w-full max-w-sm mx-4">
                    <div class="flex items-center justify-between mb-4">
                        <p class="font-medium text-gray-800">Scan QR Tamu</p>
                        <button onclick="closeScanner()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div id="qr-reader" class="rounded-xl overflow-hidden"></div>
                    <p id="scan-result" class="text-sm text-center text-gray-400 mt-3">Arahkan kamera ke QR code tamu</p>
                </div>
            </div>

            {{-- Hasil pencarian --}}
            @if($query && $guests->isEmpty())
                <p class="text-center text-gray-400 text-sm py-8">Tamu tidak ditemukan.</p>
            @endif

            @foreach($guests as $guest)
                <div class="bg-white rounded-2xl border border-gray-100 p-5 mb-3">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <p class="font-medium text-gray-800">{{ $guest->nama_utama }}</p>
                            <p class="text-sm text-gray-400">{{ $guest->jumlah_tamu }} tamu · #{{ $guest->nomor_undangan ?? '-' }}</p>
                        </div>
                        <span @class([
                            'text-xs px-2 py-1 rounded-full font-medium',
                            'bg-gray-100 text-gray-500' => $guest->status === 'terdaftar',
                            'bg-green-100 text-green-700' => $guest->status === 'hadir',
                            'bg-blue-100 text-blue-700' => $guest->status === 'souvenir_diambil',
                        ])>
                            {{ match($guest->status) {
                                'terdaftar' => 'Belum hadir',
                                'hadir' => 'Sudah hadir',
                                'souvenir_diambil' => 'Souvenir diambil',
                            } }}
                        </span>
                    </div>

                    @if(!$guest->sudahCheckIn())
                        <form method="POST" action="{{ route('receptionist.checkin', $event) }}" class="checkin-form">
                            @csrf
                            <input type="hidden" name="guest_id" value="{{ $guest->id }}">
                            <input type="hidden" name="metode" value="manual">

                            <div class="flex items-center gap-3">
                                <label class="text-sm text-gray-500">Jumlah hadir:</label>
                                <input
                                    type="number"
                                    name="jumlah_hadir"
                                    value="{{ $guest->jumlah_tamu }}"
                                    min="1"
                                    max="{{ $guest->jumlah_tamu }}"
                                    class="w-16 border border-gray-200 rounded-lg px-2 py-1 text-sm text-center"
                                />
                                <button type="button"
                                    onclick="confirmCheckin(this.closest('form'), '{{ $guest->nama_utama }}')"
                                    class="ml-auto bg-gray-800 text-white rounded-xl px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">
                                    Check-in
                                </button>
                            </div>
                        </form>
                    @else
                        <p class="text-sm text-gray-400">
                            Hadir {{ $guest->checkIn->jumlah_hadir }} orang
                            · {{ $guest->checkIn->waktu_checkin->format('H:i') }}
                        </p>
                    @endif
                </div>
            @endforeach

        </div>
    </div>

    <style>
        #qr-reader video,
        #qr-reader canvas {
            transform: none !important;
            -webkit-transform: none !important;
        }
    </style>   

    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let scanner = null;

        function openScanner() {
            document.getElementById('scanner-modal').classList.remove('hidden');
            scanner = new Html5QrcodeScanner('qr-reader', {
                fps: 10,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0,
            });

            scanner.render(async (decodedText) => {
                await scanner.clear();
                scanner = null;
                closeScanner();
                await processQr(decodedText);
            });
        }

        function closeScanner() {
            if (scanner) {
                scanner.clear().catch(() => {});
                scanner = null;
            }
            document.getElementById('scanner-modal').classList.add('hidden');
        }

        async function processQr(qrCode) {
            const url = `/event/{{ $event->id }}/receptionist/scan/${qrCode}`;
            const res = await fetch(url);
            const data = await res.json();

            if (data.success) {
                showAlert('success', `✓ ${data.message} · ${data.guest.jumlah_tamu} tamu`);
            } else {
                showAlert('error', data.message);
            }
        }

        function showAlert(type, message) {
            const colors = type === 'success'
                ? 'bg-green-50 border-green-200 text-green-700'
                : 'bg-red-50 border-red-200 text-red-700';

            const el = document.createElement('div');
            el.className = `${colors} border rounded-xl px-4 py-3 text-sm mb-4`;
            el.textContent = message;

            const container = document.querySelector('.max-w-2xl');
            container.insertBefore(el, container.firstChild);

            setTimeout(() => el.remove(), 4000);
        }
    </script>

    <script>
        function confirmCheckin(form, nama) {
            Swal.fire({
                title: 'Konfirmasi Check-in',
                text: `${nama} akan dicatat sebagai hadir.`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#1f2937',
                cancelButtonColor: '#e5e7eb',
                confirmButtonText: 'Ya, check-in',
                cancelButtonText: 'Batal',
                reverseButtons: true,
            }).then((result) => {
                if (result.isConfirmed) form.submit();
            });
        }
    </script>


</x-layouts.pin>