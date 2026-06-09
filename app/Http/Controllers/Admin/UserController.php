<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereHas('role', fn($q) => $q->where('name', 'client'))
            ->with(['role', 'assignedEvents'])
            ->orderBy('name')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $events = Event::where('created_by', auth()->id())->orderBy('nama_event')->get();
        return view('admin.users.create', compact('events'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'event_ids' => 'nullable|array',
            'event_ids.*' => 'exists:events,id',
        ]);

        $clientRole = Role::where('name', 'client')->first();

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $clientRole->id,
        ]);

        if ($request->event_ids) {
            $user->assignedEvents()->sync($request->event_ids);
        }

        return redirect()->route('admin.users.index')->with('success', 'User client berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $events = Event::where('created_by', auth()->id())->orderBy('nama_event')->get();
        $assignedEventIds = $user->assignedEvents->pluck('id')->toArray();
        return view('admin.users.edit', compact('user', 'events', 'assignedEventIds'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'event_ids' => 'nullable|array',
            'event_ids.*' => 'exists:events,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        $user->assignedEvents()->sync($request->event_ids ?? []);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}