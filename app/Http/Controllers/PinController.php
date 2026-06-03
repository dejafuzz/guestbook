<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PinController extends Controller
{
    public function show(Request $request, Event $event) 
    {

        $type = $request->query('type', 'receptionist');
        
        return view('pin.show', compact('event', 'type'));
    }

    public function verify(Request $request, Event $event)
    {

        $request->validate([
            'pin' => 'required|digits:6',
            'type' => 'required|in:receptionist,souvenir',
        ]);

        $type = $request->type;
        $pin = $request->pin;

        $isValid = match($type) {
            'receptionist' => Hash::check($pin, $event->receptionist_pin),
            'souvenir' => Hash::check($pin, $event->souvenir_pin),
        };

        if (!$isValid) {
            return back()->withErrors(['pin' => 'PIN tidak valid.']);
        }

        session(["pin_{$type}_{$event->id}" => true]);

        return match($type) {
            'receptionist' => redirect()->route('receptionist.index', $event),
            'souvenir' => redirect()->route('souvenir.index', $event),
        };
    }
}