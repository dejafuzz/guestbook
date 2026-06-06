<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Event</h2>
            <a href="{{ route('admin.events.create') }}" class="bg-gray-800 text-white rounded-xl px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">
                + Buat Event
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if($events->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
                    <p class="text-gray-400 text-sm mb-4">Belum ada event.</p>
                    <a href="{{ route('admin.events.create') }}" class="bg-gray-800 text-white rounded-xl px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">
                        Buat Event Pertama
                    </a>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach($events as $event)
                        <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-800">{{ $event->nama_event }}</p>
                                <p class="text-sm text-gray-400 mt-1">
                                    {{ $event->tanggal->format('d F Y') }}
                                    @if($event->lokasi) · {{ $event->lokasi }} @endif
                                </p>
                                <p class="text-sm text-gray-400">
                                    {{ $event->guests()->count() }} tamu terdaftar
                                </p>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.events.show', $event) }}" class="border border-gray-200 text-gray-700 rounded-xl px-4 py-2 text-sm font-medium hover:bg-gray-50 transition">
                                    Kelola
                                </a>

                                <form method="POST" action="{{ route('admin.events.destroy', $event) }}" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        onclick="confirmDelete(this.closest('form'), 'Hapus event ini?', 'Event dan semua data tamu akan dihapus permanen.')"
                                        class="text-red-400 hover:text-red-600 text-sm">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>