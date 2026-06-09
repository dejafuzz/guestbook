<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Kelola User</h2>
            <a href="{{ route('admin.users.create') }}" class="bg-gray-800 text-white rounded-xl px-4 py-2 text-sm font-medium hover:bg-gray-700 transition">
                + Tambah User
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4">

            @if(session('success'))
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                @if($users->isEmpty())
                    <p class="text-center text-gray-400 text-sm py-12">Belum ada user client.</p>
                @else
                    <div class="divide-y divide-gray-50">
                        @foreach($users as $user)
                            <div class="px-6 py-4 flex items-center justify-between">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $user->name }}</p>
                                    <p class="text-sm text-gray-400">{{ $user->email }}</p>
                                    @if($user->assignedEvents->isNotEmpty())
                                        <div class="flex flex-wrap gap-1 mt-1">
                                            @foreach($user->assignedEvents as $event)
                                                <span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">{{ $event->nama_event }}</span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-gray-400 hover:text-gray-600 text-xs">Edit</a>
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="confirmDelete(this.closest('form'), 'Hapus user ini?', '{{ $user->name }} akan dihapus permanen.')"
                                            class="text-red-400 hover:text-red-600 text-xs">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="px-6 py-4 border-t border-gray-100">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>