<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use Illuminate\Http\Request;

class ReceptionistController extends Controller
{
    public function index(Request $request, Event $event)
    {
        $query = $request->get('search');
        $guests = collect();

        if ($query) {
            $guests = Guest::where('event_id', $event->id)
                ->where('nama_utama', 'ilike', "%{$query}%")
                ->get();
        }

        return view('receptionist.index', compact('event', 'guests', 'query'));
    }

    public function checkIn(Request $request, Event $event)
    {
        $request->validate([
            'guest_id' => 'required|uuid|exists:guests,id',
            'jumlah_hadir' => 'required|integer|min:1',
            'metode' => 'required|in:qr,manual',
        ]);

        $guest = Guest::where('id', $request->guest_id)
            ->where('event_id', $event->id)
            ->firstOrFail();

        if ($guest->sudahCheckIn()) {
            return back()->with('error', 'Tamu ini sudah check-in sebelumnya.');
        }

        $guest->checkIn()->create([
            'jumlah_hadir' => $request->jumlah_hadir,
            'metode' => $request->metode,
            'dicatat_oleh' => session('receptionist_name') ?? 'Usher',
        ]);

        $guest->update(['status' => 'hadir']);

        return back()->with('success', "Tamu {$guest->nama_utama} berhasil check-in.");
    }
}