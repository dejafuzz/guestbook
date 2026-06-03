<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $event->nama_event }}</h2>
                <p class="text-sm text-gray-400">{{ $event->tanggal->format('d F Y') }} · {{ $event->lokasi }}</p>
            </div>
            <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4">

            {{-- Statistik --}}
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center">
                    <p class="text-2xl font-medium text-gray-800">{{ $totalTamu }}</p>
                    <p class="text-sm text-gray-400 mt-1">Total Tamu</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center">
                    <p class="text-2xl font-medium text-green-600">{{ $totalHadir }}</p>
                    <p class="text-sm text-gray-400 mt-1">Sudah Hadir</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-5 text-center">
                    <p class="text-2xl font-medium text-blue-600">{{ $totalSouvenir }}</p>
                    <p class="text-sm text-gray-400 mt-1">Souvenir Diambil</p>
                </div>
            </div>

            {{-- Menu --}}
            <div class="grid grid-cols-2 gap-4">
                <a href="{{ route('admin.guests.index', $event) }}" class="bg-white rounded-2xl border border-gray-100 p-6 hover:border-gray-300 transition">
                    <p class="font-medium text-gray-800 mb-1">Kelola Tamu</p>
                    <p class="text-sm text-gray-400">Import, lihat, dan hapus daftar tamu</p>
                </a>
                <a href="{{ route('receptionist.index', $event) }}" target="_blank" class="bg-white rounded-2xl border border-gray-100 p-6 hover:border-gray-300 transition">
                    <p class="font-medium text-gray-800 mb-1">Halaman Resepsionis</p>
                    <p class="text-sm text-gray-400">Buka halaman check-in untuk usher</p>
                </a>
            </div>

        </div>
    </div>
</x-app-layout>