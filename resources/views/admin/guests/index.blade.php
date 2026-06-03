<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Daftar Tamu — {{ $event->nama_event }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4">

            {{-- Alert --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Import form --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
                <h3 class="font-medium text-gray-800 mb-1">Import Tamu</h3>
                <p class="text-sm text-gray-400 mb-4">Upload file Excel atau CSV dengan kolom: <code class="bg-gray-100 px-1 rounded">nama_utama</code>, <code class="bg-gray-100 px-1 rounded">nomor_undangan</code>, <code class="bg-gray-100 px-1 rounded">jumlah_tamu</code></p>

                <form method="POST" action="{{ route('admin.guests.import', $event) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex gap-3 items-center">
                        <input type="file" name="file" accept=".xlsx,.xls,.csv"
                            class="flex-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                        <button type="submit" class="bg-gray-800 text-white rounded-xl px-5 py-2 text-sm font-medium hover:bg-gray-700 transition">
                            Import
                        </button>
                    </div>
                    @error('file')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </form>
            </div>

            {{-- Tabel tamu --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <p class="font-medium text-gray-800">{{ $guests->total() }} tamu terdaftar</p>
                </div>

                @if($guests->isEmpty())
                    <p class="text-center text-gray-400 text-sm py-12">Belum ada tamu. Import file CSV untuk memulai.</p>
                @else
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                            <tr>
                                <th class="px-6 py-3 text-left">Nama</th>
                                <th class="px-6 py-3 text-left">No. Undangan</th>
                                <th class="px-6 py-3 text-center">Jumlah Tamu</th>
                                <th class="px-6 py-3 text-center">Status</th>
                                <th class="px-6 py-3"></th>
                                <th class="px-6 py-3 text-center">Undangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @foreach($guests as $guest)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-800">{{ $guest->nama_utama }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $guest->nomor_undangan ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center text-gray-600">{{ $guest->jumlah_tamu }}</td>
                                    <td class="px-6 py-4 text-center">
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
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <form method="POST" action="{{ route('admin.guests.destroy', [$event, $guest]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-600 text-xs" onclick="return confirm('Hapus tamu ini?')">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <a href="{{ route('invitation.show', [$event->slug, $guest->qr_code]) }}"
                                            target="_blank"
                                            class="text-blue-500 hover:text-blue-700 text-xs">
                                            Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $guests->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>