<x-layouts.pin>
    <div class="min-h-screen flex items-center justify-center bg-gray-50">
        <div class="bg-white rounded-2xl shadow p-8 w-full max-w-sm">
            <h1 class="text-xl font-medium text-gray-800 mb-1">
                {{ $event->nama_event }}
            </h1>
            <p class="text-sm text-gray-500 mb-6">
                Masukkan PIN {{ $type === 'receptionist' ? 'Resepsionis' : 'Souvenir' }}
            </p>

            <form method="POST" action="{{ route('pin.verify', $event) }}">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">

                <input
                    type="password"
                    name="pin"
                    maxlength="6"
                    placeholder="••••••"
                    autofocus
                    class="w-full text-center text-2xl tracking-widest border border-gray-200 rounded-xl px-4 py-3 mb-4 focus:outline-none focus:ring-2 focus:ring-gray-300"
                />

                @error('pin')
                    <p class="text-red-500 text-sm text-center mb-4">{{ $message }}</p>
                @enderror

                <button type="submit" class="w-full bg-gray-800 text-white rounded-xl py-3 font-medium hover:bg-gray-700 transition">
                    Masuk
                </button>
            </form>
        </div>
    </div>
</x-layouts.pin>