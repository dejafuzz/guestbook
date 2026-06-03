<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Buat Event</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4">
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <form method="POST" action="{{ route('admin.events.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Event</label>
                        <input type="text" name="nama_event" value="{{ old('nama_event') }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        @error('nama_event') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                        <input type="text" name="lokasi" value="{{ old('lokasi') }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        @error('lokasi') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Mode Souvenir</label>
                        <select name="souvenir_mode" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300">
                            <option value="per_orang" {{ old('souvenir_mode') === 'per_orang' ? 'selected' : '' }}>Per orang</option>
                            <option value="per_undangan" {{ old('souvenir_mode') === 'per_undangan' ? 'selected' : '' }}>Per undangan</option>
                        </select>
                        @error('souvenir_mode') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">PIN Resepsionis</label>
                            <input type="text" name="receptionist_pin" maxlength="6" value="{{ old('receptionist_pin') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-center tracking-widest focus:outline-none focus:ring-2 focus:ring-gray-300" />
                            @error('receptionist_pin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">PIN Souvenir</label>
                            <input type="text" name="souvenir_pin" maxlength="6" value="{{ old('souvenir_pin') }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-center tracking-widest focus:outline-none focus:ring-2 focus:ring-gray-300" />
                            @error('souvenir_pin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">Template Undangan</label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="template" value="classic" class="sr-only peer" checked />
                                <div class="border-2 border-transparent peer-checked:border-gray-800 rounded-xl p-3 text-center bg-gray-50 hover:bg-gray-100 transition">
                                    <div class="w-full h-16 bg-gray-800 rounded-lg mb-2"></div>
                                    <p class="text-xs font-medium text-gray-700">Classic</p>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="template" value="modern" class="sr-only peer" />
                                <div class="border-2 border-transparent peer-checked:border-rose-400 rounded-xl p-3 text-center bg-gray-50 hover:bg-gray-100 transition">
                                    <div class="w-full h-16 bg-gradient-to-br from-rose-300 to-pink-400 rounded-lg mb-2"></div>
                                    <p class="text-xs font-medium text-gray-700">Modern</p>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="template" value="floral" class="sr-only peer" />
                                <div class="border-2 border-transparent peer-checked:border-emerald-500 rounded-xl p-3 text-center bg-gray-50 hover:bg-gray-100 transition">
                                    <div class="w-full h-16 bg-gradient-to-br from-emerald-300 to-teal-400 rounded-lg mb-2"></div>
                                    <p class="text-xs font-medium text-gray-700">Floral</p>
                                </div>
                            </label>
                        </div>
                        @error('template') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-3">
                        <a href="{{ route('admin.events.index') }}" class="flex-1 text-center border border-gray-200 text-gray-700 rounded-xl px-4 py-2.5 text-sm font-medium hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit" class="flex-1 bg-gray-800 text-white rounded-xl px-4 py-2.5 text-sm font-medium hover:bg-gray-700 transition">
                            Buat Event
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>