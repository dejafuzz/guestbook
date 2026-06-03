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
                        <form method="POST" action="{{ route('receptionist.checkin', $event) }}">
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
                                <button type="submit" class="ml-auto bg-gray-800 text-white rounded-xl px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">
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
</x-layouts.pin>