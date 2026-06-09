<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Imports\GuestImport;
use App\Models\Event;
use App\Models\Guest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class GuestController extends Controller
{
    protected function authorizeEvent(Event $event): void
    {
        if (!auth()->user()->assignedEvents->contains($event->id)) {
            abort(403);
        }
    }

    public function index(Request $request, Event $event)
    {
        $this->authorizeEvent($event);
        $search = $request->get('search');
        $content = $event->invitationContent;

        $guests = $event->guests()
            ->when($search, function($q) use ($search) {
                $q->whereRaw("similarity(nama_utama, ?) > 0.1 OR nama_utama ILIKE ?", [$search, "%{$search}%"])
                    ->orderByRaw("similarity(nama_utama, ?) DESC", [$search]);
            })
            ->when(!$search, fn($q) => $q->orderBy('nama_utama'))
            ->paginate(20)
            ->withQueryString();

        return view('client.guests.index', compact('event', 'guests', 'search', 'content'));
    }

    public function create(Event $event)
    {
        $this->authorizeEvent($event);
        return view('client.guests.create', compact('event'));
    }

    public function store(Request $request, Event $event)
    {
        $this->authorizeEvent($event);
        $request->validate([
            'nama_utama' => 'required|string|max:255',
            'nomor_undangan' => 'nullable|string|max:50',
            'jumlah_tamu' => 'required|integer|min:1',
        ]);

        $event->guests()->create($request->only(['nama_utama', 'nomor_undangan', 'jumlah_tamu']));
        return redirect()->route('client.guests.index', $event)->with('success', 'Tamu berhasil ditambahkan.');
    }

    public function edit(Event $event, Guest $guest)
    {
        $this->authorizeEvent($event);
        return view('client.guests.edit', compact('event', 'guest'));
    }

    public function update(Request $request, Event $event, Guest $guest)
    {
        $this->authorizeEvent($event);
        $request->validate([
            'nama_utama' => 'required|string|max:255',
            'nomor_undangan' => 'nullable|string|max:50',
            'jumlah_tamu' => 'required|integer|min:1',
        ]);

        $guest->update($request->only(['nama_utama', 'nomor_undangan', 'jumlah_tamu']));
        return redirect()->route('client.guests.index', $event)->with('success', 'Tamu berhasil diperbarui.');
    }

    public function destroy(Event $event, Guest $guest)
    {
        $this->authorizeEvent($event);
        $guest->delete();
        return redirect()->route('client.guests.index', $event)->with('success', 'Tamu berhasil dihapus.');
    }

    public function import(Request $request, Event $event)
    {
        $this->authorizeEvent($event);
        $request->validate(['file' => 'required|file|extensions:csv,xls,xlsx|max:2048']);

        $import = new GuestImport($event->id);
        Excel::import($import, $request->file('file'));

        $failures = $import->getFailures();
        if (!empty($failures)) {
            $errors = [];
            foreach ($failures as $failure) {
                $errors[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            return back()->with('import_errors', $errors)->with('warning', 'Import selesai dengan beberapa baris yang dilewati.');
        }

        return back()->with('success', 'Data tamu berhasil diimport.');
    }
}