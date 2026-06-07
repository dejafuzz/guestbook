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

            {{-- Modal konfirmasi check-in --}}
            <div id="checkin-modal" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-2xl p-6 w-full max-w-sm mx-4">
                    <div class="flex items-center justify-between mb-5">
                        <p class="font-medium text-gray-800">Konfirmasi Check-in</p>
                        <button onclick="closeCheckinModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>

                    {{-- Info tamu --}}
                    <div class="bg-gray-50 rounded-xl p-4 mb-5">
                        <p class="text-xs text-gray-400 mb-1">Nama Tamu</p>
                        <p class="font-medium text-gray-800 text-lg" id="modal-nama"></p>
                        <p class="text-sm text-gray-400 mt-1">No. Undangan: <span id="modal-nomor"></span></p>
                    </div>

                    {{-- Input jumlah hadir --}}
                    <div class="mb-5">
                        <label class="block text-sm text-gray-600 mb-2">Jumlah tamu yang hadir</label>
                        <div class="flex items-center gap-3">
                            <button type="button" onclick="decrementHadir()"
                                class="w-10 h-10 rounded-xl border border-gray-200 text-gray-600 text-lg font-medium hover:bg-gray-50 transition">
                                −
                            </button>
                            <input type="number" id="modal-jumlah-hadir" min="1"
                                class="flex-1 border border-gray-200 rounded-xl px-4 py-2 text-center text-lg font-medium focus:outline-none focus:ring-2 focus:ring-gray-300" />
                            <button type="button" onclick="incrementHadir()"
                                class="w-10 h-10 rounded-xl border border-gray-200 text-gray-600 text-lg font-medium hover:bg-gray-50 transition">
                                +
                            </button>
                        </div>
                        <p class="text-xs text-gray-400 mt-1 text-center">Maksimal <span id="modal-max-hadir"></span> tamu</p>
                    </div>

                    <input type="hidden" id="modal-guest-id" />

                    <div class="flex gap-3">
                        <button onclick="closeCheckinModal()"
                            class="flex-1 border border-gray-200 text-gray-700 rounded-xl px-4 py-2.5 text-sm font-medium hover:bg-gray-50 transition">
                            Batal
                        </button>
                        <button onclick="submitCheckin()"
                            class="flex-1 bg-gray-800 text-white rounded-xl px-4 py-2.5 text-sm font-medium hover:bg-gray-700 transition">
                            Check-in
                        </button>
                    </div>
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

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        let scanner = null;
        let maxHadir = 1;

        // Scanner
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

            if (!data.success && data.already_checkin) {
                Swal.fire({
                    icon: 'info',
                    title: 'Sudah Check-in',
                    html: `<b>${data.guest.nama}</b> sudah check-in pukul ${data.guest.waktu_checkin}<br>Jumlah hadir: ${data.guest.jumlah_hadir} orang`,
                    confirmButtonColor: '#1f2937',
                });
                return;
            }

            if (!data.success) {
                Swal.fire({
                    icon: 'error',
                    title: 'Tidak Ditemukan',
                    text: data.message,
                    confirmButtonColor: '#1f2937',
                });
                return;
            }

            openCheckinModal(data.guest);
        }

        // Modal check-in
        function openCheckinModal(guest) {
            maxHadir = guest.jumlah_tamu;
            document.getElementById('modal-guest-id').value = guest.id;
            document.getElementById('modal-nama').textContent = guest.nama;
            document.getElementById('modal-nomor').textContent = guest.nomor_undangan;
            document.getElementById('modal-jumlah-hadir').value = guest.jumlah_tamu;
            document.getElementById('modal-jumlah-hadir').max = guest.jumlah_tamu;
            document.getElementById('modal-max-hadir').textContent = guest.jumlah_tamu;
            document.getElementById('checkin-modal').classList.remove('hidden');
        }

        function closeCheckinModal() {
            document.getElementById('checkin-modal').classList.add('hidden');
        }

        function incrementHadir() {
            const input = document.getElementById('modal-jumlah-hadir');
            input.value = parseInt(input.value) + 1;
        }

        function decrementHadir() {
            const input = document.getElementById('modal-jumlah-hadir');
            if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
        }

        async function submitCheckin() {
            const guestId = document.getElementById('modal-guest-id').value;
            const jumlahHadir = document.getElementById('modal-jumlah-hadir').value;
            const nama = document.getElementById('modal-nama').textContent;

            const res = await fetch('{{ route('receptionist.checkin', $event) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    guest_id: guestId,
                    jumlah_hadir: jumlahHadir,
                    metode: 'qr',
                }),
            });

            const data = await res.json();
            closeCheckinModal();

            Swal.fire({
                icon: data.success ? 'success' : 'error',
                title: data.success ? 'Check-in Berhasil' : 'Gagal',
                text: data.message,
                confirmButtonColor: '#1f2937',
                timer: data.success ? 2500 : null,
                timerProgressBar: data.success,
            });
        }

        // SweetAlert untuk check-in manual
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