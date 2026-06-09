<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monitor · {{ $event->nama_event }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="refresh" content="30">
</head>
<body class="bg-gray-50 min-h-screen">

    <div class="max-w-2xl mx-auto px-4 py-8">

        {{-- Header --}}
        <div class="mb-8">
            <p class="text-xs text-gray-400 uppercase tracking-widest mb-1">Live Monitor</p>
            <h1 class="text-2xl font-medium text-gray-800">{{ $event->nama_event }}</h1>
            <p class="text-sm text-gray-400">{{ $event->tanggal->format('d F Y') }} · {{ $event->lokasi }}</p>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-2 gap-3 mb-8">
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <p class="text-3xl font-medium text-gray-800">{{ $stats['hadir'] }}</p>
                <p class="text-sm text-gray-400 mt-1">Sudah hadir</p>
                <div class="mt-3 bg-gray-100 rounded-full h-1.5">
                    <div class="bg-green-500 h-1.5 rounded-full transition-all duration-500"
                        style="width: {{ $stats['persentase'] }}%"></div>
                </div>
                <p class="text-xs text-gray-400 mt-1">{{ $stats['persentase'] }}% dari total</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <p class="text-3xl font-medium text-gray-800">{{ $stats['belum_hadir'] }}</p>
                <p class="text-sm text-gray-400 mt-1">Belum hadir</p>
                <p class="text-xs text-gray-400 mt-4">dari {{ $stats['total'] }} tamu terdaftar</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <p class="text-3xl font-medium text-gray-800">{{ $stats['total'] }}</p>
                <p class="text-sm text-gray-400 mt-1">Total terdaftar</p>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <p class="text-3xl font-medium text-gray-800">{{ $stats['souvenir'] }}</p>
                <p class="text-sm text-gray-400 mt-1">Souvenir diambil</p>
            </div>
        </div>

        {{-- Filter --}}
        <div class="flex gap-2 mb-4">
            <a href="?filter=semua" @class([
                'px-4 py-2 rounded-xl text-sm font-medium transition',
                'bg-gray-800 text-white' => $filter === 'semua',
                'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' => $filter !== 'semua',
            ])>Semua</a>
            <a href="?filter=hadir" @class([
                'px-4 py-2 rounded-xl text-sm font-medium transition',
                'bg-gray-800 text-white' => $filter === 'hadir',
                'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' => $filter !== 'hadir',
            ])>Sudah hadir</a>
            <a href="?filter=belum_hadir" @class([
                'px-4 py-2 rounded-xl text-sm font-medium transition',
                'bg-gray-800 text-white' => $filter === 'belum_hadir',
                'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' => $filter !== 'belum_hadir',
            ])>Belum hadir</a>
        </div>

        {{-- List tamu --}}
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            @if($guests->isEmpty())
                <p class="text-center text-gray-400 text-sm py-12">Belum ada data.</p>
            @else
                <div class="divide-y divide-gray-50">
                    @foreach($guests as $guest)
                        <div class="px-5 py-4 flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-800">{{ $guest->nama_utama }}</p>
                                <p class="text-xs text-gray-400">{{ $guest->jumlah_tamu }} tamu</p>
                            </div>
                            <span @class([
                                'text-xs px-2.5 py-1 rounded-full font-medium',
                                'bg-gray-100 text-gray-500' => $guest->status === 'terdaftar',
                                'bg-green-100 text-green-700' => $guest->status === 'hadir',
                                'bg-blue-100 text-blue-700' => $guest->status === 'souvenir_diambil',
                            ])>
                                {{ match($guest->status) {
                                    'terdaftar' => 'Belum hadir',
                                    'hadir' => 'Hadir',
                                    'souvenir_diambil' => 'Souvenir diambil',
                                } }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <p class="text-center text-xs text-gray-300 mt-6">
            Auto refresh setiap 30 detik · {{ now()->format('H:i:s') }}
        </p>

    </div>

</body>
</html>