<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4">

            {{-- Greeting --}}
            <div class="mb-8">
                <p class="text-2xl font-medium text-gray-800">Selamat datang, {{ Auth::user()->name }} 👋</p>
                <p class="text-sm text-gray-400 mt-1">{{ now()->format('l, d F Y') }}</p>
            </div>

            {{-- Stats --}}
            @php
                $totalEvents = \App\Models\Event::where('created_by', auth()->id())->count();
                $totalGuests = \App\Models\Guest::whereHas('event', fn($q) => $q->where('created_by', auth()->id()))->count();
                $totalHadir = \App\Models\Guest::whereHas('event', fn($q) => $q->where('created_by', auth()->id()))->whereIn('status', ['hadir', 'souvenir_diambil'])->count();
            @endphp

            <div class="grid grid-cols-3 gap-4 mb-8">
                <div class="bg-white rounded-2xl border border-gray-100 p-5">
                    <p class="text-3xl font-medium text-gray-800">{{ $totalEvents }}</p>
                    <p class="text-sm text-gray-400 mt-1">Total Event</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-5">
                    <p class="text-3xl font-medium text-gray-800">{{ $totalGuests }}</p>
                    <p class="text-sm text-gray-400 mt-1">Total Tamu</p>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-5">
                    <p class="text-3xl font-medium text-gray-800">{{ $totalHadir }}</p>
                    <p class="text-sm text-gray-400 mt-1">Total Hadir</p>
                </div>
            </div>

            {{-- Event terbaru --}}
            <div class="flex items-center justify-between mb-4">
                <p class="font-medium text-gray-800">Event Terbaru</p>
                <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-400 hover:text-gray-600">Lihat semua →</a>
            </div>

            @php
                $recentEvents = \App\Models\Event::where('created_by', auth()->id())
                    ->orderByDesc('tanggal')
                    ->limit(5)
                    ->get();
            @endphp

            @if($recentEvents->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
                    <p class="text-gray-400 text-sm mb-4">Belum ada event.</p>
                    <a href="{{ route('admin.events.create') }}"
                        class="bg-gray-800 text-white rounded-xl px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">
                        Buat Event Pertama
                    </a>
                </div>
            @else
                <div class="grid gap-3">
                    @foreach($recentEvents as $event)
                        <div class="bg-white rounded-2xl border border-gray-100 p-5 flex items-center justify-between">
                            <div>
                                <p class="font-medium text-gray-800">{{ $event->nama_event }}</p>
                                <p class="text-sm text-gray-400 mt-0.5">
                                    {{ $event->tanggal->format('d F Y') }}
                                    @if($event->lokasi) · {{ $event->lokasi }} @endif
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $event->guests()->count() }} tamu ·
                                    {{ $event->guests()->whereIn('status', ['hadir', 'souvenir_diambil'])->count() }} hadir
                                </p>
                            </div>
                            <a href="{{ route('admin.events.show', $event) }}"
                                class="border border-gray-200 text-gray-700 rounded-xl px-4 py-2 text-sm font-medium hover:bg-gray-50 transition">
                                Kelola
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>