<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4">

            <div class="mb-8">
                <p class="text-2xl font-medium text-gray-800">Selamat datang, {{ Auth::user()->name }} 👋</p>
                <p class="text-sm text-gray-400 mt-1">{{ now()->format('l, d F Y') }}</p>
            </div>

            @if($events->isEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
                    <p class="text-gray-400 text-sm">Belum ada event yang ditugaskan.</p>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach($events as $event)
                        <div class="bg-white rounded-2xl border border-gray-100 p-6">
                            <div class="flex items-start justify-between mb-4">
                                <div>
                                    <p class="font-medium text-gray-800 text-lg">{{ $event->nama_event }}</p>
                                    <p class="text-sm text-gray-400 mt-0.5">
                                        {{ $event->tanggal->format('d F Y') }}
                                        @if($event->lokasi) · {{ $event->lokasi }} @endif
                                    </p>
                                </div>
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">
                                    {{ $event->guests_count }} tamu
                                </span>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <a href="{{ route('client.guests.index', $event) }}"
                                    class="flex items-center gap-3 border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Kelola Tamu</p>
                                        <p class="text-xs text-gray-400">Import & manage tamu</p>
                                    </div>
                                </a>

                                <a href="{{ route('receptionist.index', $event) }}"
                                    target="_blank"
                                    class="flex items-center gap-3 border border-gray-200 rounded-xl p-4 hover:bg-gray-50 transition">
                                    <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">Resepsionis</p>
                                        <p class="text-xs text-gray-400">Halaman check-in tamu</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>