<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Daftar Tamu — {{ $event->nama_event }}
                </h2>
            </div>
            <a href="{{ route('admin.events.show', $event->id) }}" class="text-sm text-gray-500 hover:text-gray-700">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4">

            {{-- Alert --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-700 rounded-xl px-4 py-3 mb-4 text-sm">
                    {{ session('warning') }}
                </div>
            @endif

            @if(session('import_errors'))
                <div class="bg-red-50 border border-red-200 rounded-xl px-4 py-3 mb-6">
                    <p class="text-red-700 text-sm font-medium mb-2">Baris berikut gagal diimport:</p>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach(session('import_errors') as $error)
                            <li class="text-red-600 text-xs">{{ $error }}</li>
                        @endforeach
                    </ul>
                    <p class="text-red-400 text-xs mt-2">Baris lain yang valid tetap berhasil diimport.</p>
                </div>
            @endif

            {{-- Import form --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5 mb-4">
                <h3 class="font-medium text-gray-800 mb-1">Import Tamu</h3>
                <p class="text-sm text-gray-400 mb-4">Upload file CSV dengan kolom:
                    <code class="bg-gray-100 px-1 rounded">nama_utama</code>,
                    <code class="bg-gray-100 px-1 rounded">nomor_undangan</code>,
                    <code class="bg-gray-100 px-1 rounded">jumlah_tamu</code>
                </p>
                <form method="POST" action="{{ route('admin.guests.import', $event) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3">
                        <input type="file" name="file" accept=".xlsx,.xls,.csv"
                            class="flex-1 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                        <button type="submit" class="bg-gray-800 text-white rounded-xl px-5 py-2 text-sm font-medium hover:bg-gray-700 transition whitespace-nowrap">
                            Import
                        </button>
                    </div>
                    @error('file')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </form>
            </div>

            {{-- Search --}}
            <div class="mb-4">
                <form method="GET" action="{{ route('admin.guests.index', $event) }}">
                    <div class="flex gap-2">
                        <input type="text" name="search" value="{{ $search ?? '' }}"
                            placeholder="Cari nama tamu..."
                            class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        <button type="submit"
                            class="bg-gray-800 text-white rounded-xl px-4 py-2.5 text-sm font-medium hover:bg-gray-700 transition whitespace-nowrap">
                            Cari
                        </button>
                        @if($search)
                            <a href="{{ route('admin.guests.index', $event) }}"
                                class="border border-gray-200 text-gray-600 rounded-xl px-4 py-2.5 text-sm hover:bg-gray-50 transition whitespace-nowrap">
                                Reset
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Tabel --}}
            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <p class="font-medium text-gray-800">{{ $guests->total() }} tamu terdaftar</p>
                    <a href="{{ route('admin.guests.create', $event) }}"
                        class="bg-gray-800 text-white rounded-xl px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">
                        + Tambah Tamu
                    </a>
                </div>

                @if($guests->isEmpty())
                    <p class="text-center text-gray-400 text-sm py-12">Belum ada tamu. Import file CSV untuk memulai.</p>
                @else
                    {{-- Mobile: card list --}}
                    <div class="divide-y divide-gray-50 sm:hidden">
                        @foreach($guests as $guest)
                            @php
                                $groomName = $content?->groom_name ?? 'Mempelai Pria';
                                $brideName = $content?->bride_name ?? 'Mempelai Wanita';
                                $invitationLink = route('invitation.show', [$event->slug, $guest->qr_code]);
                                $waMessage = "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\n" .
                                    "Kepada Yth. Bapak/Ibu/Saudara/i *{$guest->nama_utama}*,\n\n" .
                                    "Mohon maaf mengganggu waktunya. Tanpa mengurangi rasa hormat, lewat pesan ini kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami.\n\n" .
                                    "Karena keterbatasan jarak, kami mengirimkan undangan digital ini sebagai pengganti undangan fisik. Informasi lengkap mengenai detail acara, lokasi, dan protokol dapat diakses melalui tautan di bawah ini:\n\n" .
                                    "{$invitationLink}\n\n" .
                                    "Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu kepada kami.\n\n" .
                                    "Atas perhatiannya, kami ucapkan terima kasih.\n\n" .
                                    "Wassalamu'alaikum Warahmatullahi Wabarakatuh.\n\n" .
                                    "Kami yang berbahagia,\n*{$groomName} & {$brideName}*";
                            @endphp
                            <div class="px-5 py-4">
                                <div class="flex items-start justify-between mb-2">
                                    <div>
                                        <p class="font-medium text-gray-800 text-sm">{{ $guest->nama_utama }}</p>
                                        <p class="text-xs text-gray-400 mt-0.5">
                                            {{ $guest->jumlah_tamu }} tamu
                                            @if($guest->nomor_undangan) · #{{ $guest->nomor_undangan }} @endif
                                        </p>
                                    </div>
                                    <span @class([
                                        'text-xs px-2 py-1 rounded-full font-medium ml-2 shrink-0',
                                        'bg-gray-100 text-gray-500' => $guest->status === 'terdaftar',
                                        'bg-green-100 text-green-700' => $guest->status === 'hadir',
                                        'bg-blue-100 text-blue-700' => $guest->status === 'souvenir_diambil',
                                    ])>
                                        {{ match($guest->status) {
                                            'terdaftar' => 'Belum hadir',
                                            'hadir' => 'Hadir',
                                            'souvenir_diambil' => 'Souvenir',
                                        } }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-4 mt-2">
                                    <a href="https://wa.me/?text={{ urlencode($waMessage) }}" target="_blank" class="text-green-500 hover:text-green-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                            <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.528 5.855L.057 23.882a.5.5 0 00.611.611l6.037-1.474A11.942 11.942 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.655-.51-5.18-1.402l-.37-.216-3.835.936.955-3.773-.234-.38A9.96 9.96 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('invitation.show', [$event->slug, $guest->qr_code]) }}" target="_blank" class="text-blue-500 hover:text-blue-700 text-xs">Lihat</a>
                                    <a href="{{ route('admin.guests.edit', [$event, $guest]) }}" class="text-gray-400 hover:text-gray-600 text-xs">Edit</a>
                                    <form method="POST" action="{{ route('admin.guests.destroy', [$event, $guest]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmDelete(this.closest('form'), 'Hapus tamu ini?', '{{ $guest->nama_utama }} akan dihapus.')"
                                            class="text-red-400 hover:text-red-600 text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Desktop: tabel --}}
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                                <tr>
                                    <th class="px-5 py-3 text-left">Nama</th>
                                    <th class="px-5 py-3 text-left">No. Undangan</th>
                                    <th class="px-5 py-3 text-center">Tamu</th>
                                    <th class="px-5 py-3 text-center">Status</th>
                                    <th class="px-5 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach($guests as $guest)
                                    @php
                                        $groomName = $content?->groom_name ?? 'Mempelai Pria';
                                        $brideName = $content?->bride_name ?? 'Mempelai Wanita';
                                        $invitationLink = route('invitation.show', [$event->slug, $guest->qr_code]);
                                        $waMessage = "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\n" .
                                            "Kepada Yth. Bapak/Ibu/Saudara/i *{$guest->nama_utama}*,\n\n" .
                                            "Mohon maaf mengganggu waktunya. Tanpa mengurangi rasa hormat, lewat pesan ini kami bermaksud mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami.\n\n" .
                                            "Karena keterbatasan jarak, kami mengirimkan undangan digital ini sebagai pengganti undangan fisik. Informasi lengkap mengenai detail acara, lokasi, dan protokol dapat diakses melalui tautan di bawah ini:\n\n" .
                                            "{$invitationLink}\n\n" .
                                            "Merupakan suatu kehormatan dan kebahagiaan bagi kami apabila Bapak/Ibu/Saudara/i berkenan hadir dan memberikan doa restu kepada kami.\n\n" .
                                            "Atas perhatiannya, kami ucapkan terima kasih.\n\n" .
                                            "Wassalamu'alaikum Warahmatullahi Wabarakatuh.\n\n" .
                                            "Kami yang berbahagia,\n*{$groomName} & {$brideName}*";
                                    @endphp
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-5 py-4 font-medium text-gray-800">{{ $guest->nama_utama }}</td>
                                        <td class="px-5 py-4 text-gray-500">{{ $guest->nomor_undangan ?? '-' }}</td>
                                        <td class="px-5 py-4 text-center text-gray-600">{{ $guest->jumlah_tamu }}</td>
                                        <td class="px-5 py-4 text-center">
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
                                        <td class="px-5 py-4">
                                            <div class="flex items-center justify-end gap-3">
                                                <a href="https://wa.me/?text={{ urlencode($waMessage) }}" target="_blank" class="text-green-500 hover:text-green-600" title="Kirim via WhatsApp">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/>
                                                        <path d="M12 0C5.373 0 0 5.373 0 12c0 2.127.558 4.122 1.528 5.855L.057 23.882a.5.5 0 00.611.611l6.037-1.474A11.942 11.942 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.885 0-3.655-.51-5.18-1.402l-.37-.216-3.835.936.955-3.773-.234-.38A9.96 9.96 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('invitation.show', [$event->slug, $guest->qr_code]) }}" target="_blank" class="text-blue-500 hover:text-blue-700 text-xs">Lihat</a>
                                                <a href="{{ route('admin.guests.edit', [$event, $guest]) }}" class="text-gray-400 hover:text-gray-600 text-xs">Edit</a>
                                                <form method="POST" action="{{ route('admin.guests.destroy', [$event, $guest]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button"
                                                        onclick="confirmDelete(this.closest('form'), 'Hapus tamu ini?', '{{ $guest->nama_utama }} akan dihapus dari daftar tamu.')"
                                                        class="text-red-400 hover:text-red-600 text-xs">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-5 py-4 border-t border-gray-100">
                        {{ $guests->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>

    <script>
    function confirmDelete(form, title, text) {
        Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1f2937',
            cancelButtonColor: '#e5e7eb',
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    }
    </script>

</x-app-layout>