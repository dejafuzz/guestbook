<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    public function show(string $slug, Request $request)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $filter = $request->get('filter', 'semua');

        $query = $event->guests();

        if ($filter === 'hadir') {
            $query->whereIn('status', ['hadir', 'souvenir_diambil']);
        } elseif ($filter === 'belum_hadir') {
            $query->where('status', 'terdaftar');
        }

        $guests = $query->orderByRaw("CASE status
            WHEN 'hadir' THEN 1
            WHEN 'souvenir_diambil' THEN 2
            WHEN 'terdaftar' THEN 3
            END"
        )->get();

        $stats = [
            'total' => $event->guests()->count(),
            'hadir' => $event->guests()->whereIn('status', ['hadir', 'souvenir_diambil'])->count(),
            'belum_hadir' => $event->guests()->where('status', 'terdaftar')->count(),
            'souvenir' => $event->guests()->where('status', 'souvenir_diambil')->count(),
        ];

        $stats['persentase'] = $stats['total'] > 0
            ? round(($stats['hadir'] / $stats['total']) * 100)
            : 0;

        return view('monitor.show', compact('event', 'guests', 'stats', 'filter'));
    }

}