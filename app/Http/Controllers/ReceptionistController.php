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
                ->whereRaw(
                    "similarity(nama_utama, ?) > 0.1 OR nama_utama ILIKE ?",
                    [$query, "%{$query}%"]
                )
                ->orderByRaw("similarity(nama_utama, ?) DESC", [$query])
                ->get();
        }

        return view('receptionist.index', compact('event', 'guests', 'query'));
    }

    public function checkIn(Request $request, Event $event)
    {
        $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'jumlah_hadir' => 'required|integer|min:1',
            'metode' => 'required|in:qr,manual',
        ]);

        $guest = Guest::where('id', $request->guest_id)
            ->where('event_id', $event->id)
            ->firstOrFail();

        if ($guest->sudahCheckIn()) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Tamu sudah check-in sebelumnya.']);
            }
            return back()->with('error', 'Tamu sudah check-in sebelumnya.');
        }

        $guest->checkIn()->create([
            'jumlah_hadir' => $request->jumlah_hadir,
            'metode' => $request->metode,
            'dicatat_oleh' => 'Usher',
        ]);

        $guest->update(['status' => 'hadir']);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Selamat datang, {$guest->nama_utama}!"
            ]);
        }

        return back()->with('success', "Tamu {$guest->nama_utama} berhasil check-in.");
    }

    public function scanResult(Request $request, Event $event, string $qr_code)
    {
        $guest = Guest::where('qr_code', $qr_code)
            ->where('event_id', $event->id)
            ->first();

        if (!$guest) {
            return response()->json([
                'success' => false,
                'message' => 'Tamu tidak ditemukan.'
            ]);
        }

        if ($guest->sudahCheckIn()) {
            return response()->json([
                'success' => false,
                'already_checkin' => true,
                'message' => 'Tamu sudah check-in sebelumnya.',
                'guest' => [
                    'nama' => $guest->nama_utama,
                    'jumlah_tamu' => $guest->jumlah_tamu,
                    'jumlah_hadir' => $guest->checkIn->jumlah_hadir,
                    'waktu_checkin' => $guest->checkIn->waktu_checkin->format('H:i'),
                ]
            ]);
        }

        return response()->json([
            'success' => true,
            'guest' => [
                'id' => $guest->id,
                'nama' => $guest->nama_utama,
                'jumlah_tamu' => $guest->jumlah_tamu,
                'nomor_undangan' => $guest->nomor_undangan ?? '-',
            ]
        ]);
    }
}