<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\GuestImport;
use App\Models\Event;
use App\Models\Guest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuestController extends Controller
{
    public function index(Event $event)
    {
        $guests = $event->guests()->orderBy('nama_utama')->paginate(20);

        return view('admin.guests.index', compact('event', 'guests'));
    }

    public function import(Request $request, Event $event)
    {
        $request->validate([
            'file' => 'required|file|extensions:csv,xls,xlsx|max:2048'
        ]);

        Excel::import(new GuestImport($event->id), $request->file('file'));

        return back()->with('success', 'Data tamu berhasil diimport.');
    }

    public function destroy(Event $event, Guest $guest)
    {
        $guest->delete();
        
        return back()->with('success', 'Tamu berhasil dihapus');
    }
}