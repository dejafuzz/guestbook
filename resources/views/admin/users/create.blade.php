<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Tambah User Client</h2>
            <a href="{{ route('admin.users.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Kembali</a>
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

                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Nama <span class="text-red-400">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" autofocus
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Email <span class="text-red-400">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Password <span class="text-red-400">*</span></label>
                        <input type="password" name="password"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm text-gray-600 mb-1">Konfirmasi Password <span class="text-red-400">*</span></label>
                        <input type="password" name="password_confirmation"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                    </div>

                    @if($events->isNotEmpty())
                    <div class="mb-6">
                        <label class="block text-sm text-gray-600 mb-2">Assign Event</label>
                        <div class="space-y-2">
                            @foreach($events as $event)
                                <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl cursor-pointer hover:bg-gray-50">
                                    <input type="checkbox" name="event_ids[]" value="{{ $event->id }}"
                                        {{ in_array($event->id, old('event_ids', [])) ? 'checked' : '' }}
                                        class="rounded border-gray-300 text-gray-800 focus:ring-gray-300" />
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $event->nama_event }}</p>
                                        <p class="text-xs text-gray-400">{{ $event->tanggal->format('d F Y') }}</p>
                                    </div>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="flex gap-3">
                        <a href="{{ route('admin.users.index') }}"
                            class="flex-1 text-center border border-gray-200 text-gray-700 rounded-xl px-4 py-2.5 text-sm font-medium hover:bg-gray-50 transition">
                            Batal
                        </a>
                        <button type="submit"
                            class="flex-1 bg-gray-800 text-white rounded-xl px-4 py-2.5 text-sm font-medium hover:bg-gray-700 transition">
                            Buat User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>