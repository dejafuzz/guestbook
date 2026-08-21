<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Konten Undangan</h2>
                <p class="text-sm text-gray-400">{{ $event->nama_event }}</p>
            </div>
            <a href="{{ route('admin.events.show', $event) }}" class="text-sm text-gray-500 hover:text-gray-700">← Kembali</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.invitation.update', $event) }}" enctype="multipart/form-data">
                @csrf

                {{-- Pengantin --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-4">
                    <h3 class="font-medium text-gray-800 mb-4">Data Pengantin</h3>

                    {{-- Nama --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Nama Panggilan Pria</label>
                            <input type="text" name="groom_name" value="{{ old('groom_name', $content->groom_name) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Nama Panggilan Wanita</label>
                            <input type="text" name="bride_name" value="{{ old('bride_name', $content->bride_name) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Nama Lengkap Pria</label>
                            <input type="text" name="groom_full_name" value="{{ old('groom_full_name', $content->groom_full_name) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Nama Lengkap Wanita</label>
                            <input type="text" name="bride_full_name" value="{{ old('bride_full_name', $content->bride_full_name) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                    </div>

                    {{-- Urutan anak --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Urutan Anak Pria</label>
                            <input type="text" name="groom_child_order" placeholder="cth: Putra pertama" value="{{ old('groom_child_order', $content->groom_child_order) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Urutan Anak Wanita</label>
                            <input type="text" name="bride_child_order" placeholder="cth: Putri kedua" value="{{ old('bride_child_order', $content->bride_child_order) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                    </div>

                    {{-- Orang tua --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Ayah Mempelai Pria</label>
                            <input type="text" name="groom_father" value="{{ old('groom_father', $content->groom_father) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Ayah Mempelai Wanita</label>
                            <input type="text" name="bride_father" value="{{ old('bride_father', $content->bride_father) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Ibu Mempelai Pria</label>
                            <input type="text" name="groom_mother" value="{{ old('groom_mother', $content->groom_mother) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Ibu Mempelai Wanita</label>
                            <input type="text" name="bride_mother" value="{{ old('bride_mother', $content->bride_mother) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                    </div>

                    {{-- Instagram --}}
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Instagram Pria</label>
                            <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                                <span class="px-3 text-gray-400 text-sm bg-gray-50 border-r border-gray-200">@</span>
                                <input type="text" name="groom_instagram" value="{{ old('groom_instagram', $content->groom_instagram) }}"
                                    class="flex-1 px-3 py-2.5 text-sm focus:outline-none" />
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Instagram Wanita</label>
                            <div class="flex items-center border border-gray-200 rounded-xl overflow-hidden">
                                <span class="px-3 text-gray-400 text-sm bg-gray-50 border-r border-gray-200">@</span>
                                <input type="text" name="bride_instagram" value="{{ old('bride_instagram', $content->bride_instagram) }}"
                                    class="flex-1 px-3 py-2.5 text-sm focus:outline-none" />
                            </div>
                        </div>
                    </div>

                    {{-- Foto --}}
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Foto Hero</label>
                            @if($content->hero_photo)
                                <img src="{{ asset('storage/' . $content->hero_photo) }}" class="w-full h-24 object-cover rounded-xl mb-2" />
                            @endif
                            <input type="file" name="hero_photo" accept="image/*"
                                class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Foto Pria</label>
                            @if($content->groom_photo)
                                <img src="{{ asset('storage/' . $content->groom_photo) }}" class="w-full h-24 object-cover rounded-xl mb-2" />
                            @endif
                            <input type="file" name="groom_photo" accept="image/*"
                                class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Foto Wanita</label>
                            @if($content->bride_photo)
                                <img src="{{ asset('storage/' . $content->bride_photo) }}" class="w-full h-24 object-cover rounded-xl mb-2" />
                            @endif
                            <input type="file" name="bride_photo" accept="image/*"
                                class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                        </div>
                    </div>
                </div>

                {{-- Quote --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-4">
                    <h3 class="font-medium text-gray-800 mb-4">Quotes</h3>
                    <div class="mb-4">
                        <label class="block text-sm text-gray-600 mb-1">Opening Quote</label>
                        <textarea name="opening_quote" rows="2"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300">{{ old('opening_quote', $content->opening_quote) }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Closing Quote</label>
                        <textarea name="closing_quote" rows="2"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300">{{ old('closing_quote', $content->closing_quote) }}</textarea>
                    </div>
                </div>

                {{-- Info Akad --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-4">
                    <h3 class="font-medium text-gray-800 mb-4">Info Akad</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Nama Tempat</label>
                            <input type="text" name="akad_location" value="{{ old('akad_location', $content->akad_location) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Tanggal & Waktu</label>
                            <input type="datetime-local" name="akad_datetime" value="{{ old('akad_datetime', $content->akad_datetime?->format('Y-m-d\TH:i')) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm text-gray-600 mb-1">Alamat</label>
                            <input type="text" name="akad_address" value="{{ old('akad_address', $content->akad_address) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm text-gray-600 mb-1">Link Google Maps</label>
                            <input type="url" name="akad_maps_url" value="{{ old('akad_maps_url', $content->akad_maps_url) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                    </div>
                </div>

                {{-- Info Resepsi --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-4">
                    <h3 class="font-medium text-gray-800 mb-4">Info Resepsi</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Nama Tempat</label>
                            <input type="text" name="reception_location" value="{{ old('reception_location', $content->reception_location) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Tanggal & Waktu</label>
                            <input type="datetime-local" name="reception_datetime" value="{{ old('reception_datetime', $content->reception_datetime?->format('Y-m-d\TH:i')) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm text-gray-600 mb-1">Alamat</label>
                            <input type="text" name="reception_address" value="{{ old('reception_address', $content->reception_address) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm text-gray-600 mb-1">Link Google Maps</label>
                            <input type="url" name="reception_maps_url" value="{{ old('reception_maps_url', $content->reception_maps_url) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                    </div>
                </div>

                {{-- Love Story --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-4">
                    <h3 class="font-medium text-gray-800 mb-4">Cerita Cinta</h3>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Tanggal Pertama Bertemu</label>
                            <input type="date" name="first_met_date" value="{{ old('first_met_date', $content->first_met_date?->format('Y-m-d')) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600 mb-1">Tanggal Lamaran</label>
                            <input type="date" name="engagement_date" value="{{ old('engagement_date', $content->engagement_date?->format('Y-m-d')) }}"
                                class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300" />
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Cerita</label>
                        <textarea name="love_story" rows="5"
                            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-gray-300">{{ old('love_story', $content->love_story) }}</textarea>
                    </div>
                </div>

                {{-- Musik --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-4">
                    <h3 class="font-medium text-gray-800 mb-4">Musik Latar</h3>
                    @if($content->music_file)
                        <div class="mb-3">
                            <audio controls class="w-full">
                                <source src="{{ asset('storage/' . $content->music_file) }}">
                            </audio>
                        </div>
                    @endif
                    <label class="block text-sm text-gray-600 mb-1">Upload File Audio (MP3, OGG, WAV — max 10MB)</label>
                    <input type="file" name="music_file" accept=".mp3,.ogg,.wav"
                        class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                    @error('music_file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Galeri --}}
                <div class="bg-white rounded-2xl border border-gray-100 p-6 mb-6">
                    <h3 class="font-medium text-gray-800 mb-4">Galeri Foto</h3>

                    @if($galleries->isNotEmpty())
                        <div class="grid grid-cols-4 gap-3 mb-4">
                            @foreach($galleries as $gallery)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $gallery->photo) }}" class="w-full h-20 object-cover rounded-xl" />
                                    <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 bg-black/30 rounded-xl transition">
                                        <button
                                            type="button"
                                            onclick="deleteGallery('{{ route('admin.invitation.gallery.destroy', [$event, $gallery]) }}')"
                                            class="text-white text-xs bg-red-500 px-2 py-1 rounded-lg">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <label class="block text-sm text-gray-600 mb-1">Upload Foto (bisa multiple)</label>
                    <input type="file" name="galleries[]" accept="image/*" multiple
                        class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200" />
                </div>

                <button type="submit" class="w-full bg-gray-800 text-white rounded-xl px-4 py-3 font-medium hover:bg-gray-700 transition">
                    Simpan Konten
                </button>

            </form>
        </div>
    </div>

    <script>
        function deleteGallery(url) {
            if (!confirm('Hapus foto ini?')) return;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ _method: 'DELETE' }),
            }).then(res => {
                if (res.ok) window.location.reload();
            });
        }
    </script>


</x-app-layout>