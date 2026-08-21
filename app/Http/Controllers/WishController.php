<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Wish;
use Illuminate\Http\Request;

class WishController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'pesan' => 'required|string|max:1000',
        ]);

        Wish::create([
            'event_id' => $event->id,
            'nama' => $request->nama,
            'pesan' => $request->pesan,
        ]);

        return response()->json(['success' => true, 'message' => 'Ucapan berhasil dikirim!']);
    }

    public function index(Event $event)
    {
        $wishes = $event->wishes()->select('nama', 'pesan', 'created_at')->get();
        return response()->json($wishes);
    }

}