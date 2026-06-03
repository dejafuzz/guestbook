<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::where('created_by', auth()->id())
            ->orderByDesc('tanggal')
            ->get();

        return view('admin.events.index', compact('events'));
    }

    public function create()
    {
        return view('admin.events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'lokasi' => 'nullable|string|max:255',
            'souvenir_mode' => 'required|in:per_orang,per_undangan',
            'receptionist_pin' => 'required|digits:6',
            'souvenir_pin' => 'required|digits:6',
            'template' => 'required|in:classic,modern,floral',
        ]);

        Event::create([
            'nama_event' => $request->nama_event,
            'template' => $request->template,
            'tanggal' => $request->tanggal,
            'lokasi' => $request->lokasi,
            'souvenir_mode' => $request->souvenir_mode,
            'receptionist_pin' => Hash::make($request->receptionist_pin),
            'souvenir_pin' => Hash::make($request->souvenir_pin),
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dibuat.');
    }

    public function show(Event $event)
    {
        $totalTamu = $event->guests()->count();
        $totalHadir = $event->guests()->where('status', '!=', 'terdaftar')->count();
        $totalSouvenir = $event->guests()->where('status', 'souvenir_diambil')->count();

        return view('admin.events.show', compact('event', 'totalTamu', 'totalHadir', 'totalSouvenir'));
    }

    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Event berhasil dihapus.');
    }

}