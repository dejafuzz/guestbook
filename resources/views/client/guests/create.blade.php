<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah Tamu</h2>
            <a href="{{ route('client.guests.index', $event) }}" class="text-sm text-gray-500 hover:text-gray-700">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto px-4">
            <div class="bg-white rounded-2xl border border-gray-100 p-6">

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 rounded-xl px-4 py-3 mb-6 text-sm">
                        @foreach($errors->all() as $error) <p>{{ $error }}</p> @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('client.guests.store', $event) }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Nama Utama <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_utama" value="{{ old('nama_utama') }}" autofocus
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        @error('nama_utama') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Nomor Undangan</label>
                        <input type="text" name="nomor_undangan" value="{{ old('nomor_undangan') }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm text-gray-600 mb-1">Jumlah Tamu <span class="text-red-400">*</span></label>
                        <input type="number" name="jumlah_tamu" value="{{ old('jumlah_tamu', 1) }}" min="1"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        @error('jumlah_tamu') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('client.guests.index', $event) }}"
                            class="flex-1 text-center border border-gray-200 text-gray-700 rounded-xl px-4 py-2.5 text-sm font-medium hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="flex-1 bg-gray-800 text-white rounded-xl px-4 py-2.5 text-sm font-medium hover:bg-gray-700 transition">
                            Tambah Tamu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>