<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Guest;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function show(string $slug, string $qr_code)
    {
        $event = Event::where('slug', $slug)->firstOrFail();
        $guest = Guest::where('qr_code', $qr_code)
                ->where('event_id', $event->id)
                ->firstOrFail();

        return view('invitation.templates.' . $event->template , compact('event', 'guest'));
    }
}