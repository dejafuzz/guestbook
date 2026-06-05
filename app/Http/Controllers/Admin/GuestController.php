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
    public function index(Request $request, Event $event)
    {
        $search = $request->get('search');

        $guests = $event->guests()
            ->when($search, function($q) use ($search) {
                $q->whereRaw(
                    "similarity(nama_utama, ?) > 0.1 OR nama_utama ILIKE ?",
                    [$search, "%{$search}%"]
                )->orderByRaw("similarity(nama_utama, ?) DESC", [$search]);
            })
            ->when(!$search, fn($q) => $q->orderBy('nama_utama'))
            ->paginate(20)
            ->withQueryString();

        return view('admin.guests.index', compact('event', 'guests', 'search'));
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

    public function edit(Event $event, Guest $guest)
    {
        return view('admin.guests.edit', compact('event', 'guest'));
    }

    public function update(Request $request, Event $event, Guest $guest)
    {
        $request->validate([
            'nama_utama' => 'required|string|max:255',
            'nomor_undangan' => 'nullable|string|max:50',
            'jumlah_tamu' => 'required|integer|min:1',
        ]);

        $guest->update($request->only(['nama_utama', 'nomor_undangan', 'jumlah_tamu']));

        return redirect()->route('admin.guests.index', $event)->with('success', 'Data tamu berhasil diperbarui.');
    }

}