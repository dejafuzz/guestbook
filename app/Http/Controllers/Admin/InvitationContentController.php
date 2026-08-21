<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\InvitationContent;
use App\Models\InvitationGallery;
use Illuminate\Http\Request;

class InvitationContentController extends Controller
{
    public function edit(Event $event)
    {
        $content = $event->invitationContent ?? new InvitationContent();
        $galleries = $event->invitationGalleries;
        return view('admin.invitation.edit', compact('event', 'content', 'galleries'));
    }

    public function update(Request $request, Event $event)
    {
        $request->validate([
            'groom_name' => 'required|string|max:255',
            'bride_name' => 'required|string|max:255',
            'groom_full_name' => 'nullable|string|max:255',
            'bride_full_name' => 'nullable|string|max:255',
            'groom_father' => 'nullable|string|max:255',
            'groom_mother' => 'nullable|string|max:255',
            'groom_child_order' => 'nullable|string|max:100',
            'groom_instagram' => 'nullable|string|max:100',
            'bride_father' => 'nullable|string|max:255',
            'bride_mother' => 'nullable|string|max:255',
            'bride_child_order' => 'nullable|string|max:100',
            'bride_instagram' => 'nullable|string|max:100',
            'groom_photo' => 'nullable|image|max:2048',
            'bride_photo' => 'nullable|image|max:2048',
            'hero_photo' => 'nullable|image|max:2048',
            'love_story' => 'nullable|string',
            'first_met_date' => 'nullable|date',
            'engagement_date' => 'nullable|date',
            'akad_location' => 'nullable|string',
            'akad_address' => 'nullable|string',
            'akad_datetime' => 'nullable|date',
            'akad_maps_url' => 'nullable|url',
            'reception_location' => 'nullable|string',
            'reception_address' => 'nullable|string',
            'reception_datetime' => 'nullable|date',
            'reception_maps_url' => 'nullable|url',
            'opening_quote' => 'nullable|string',
            'closing_quote' => 'nullable|string',
            'music_file' => 'nullable|file|mimes:mp3,ogg,wav|max:10240',
        ]);

        $data = $request->except(['groom_photo', 'bride_photo', 'hero_photo', 'galleries']);

        foreach (['groom_photo', 'bride_photo', 'hero_photo'] as $photo) {
            if ($request->hasFile($photo)) {
                $data[$photo] = $request->file($photo)->store("events/{$event->id}", 'public');
            }
        }
        
        // Handling upload audio
        if ($request->hasFile('music_file')) {
            $data['music_file'] = $request->file('music_file')->store("events/{$event->id}/music", 'public');
        }

        $event->invitationContent()->updateOrCreate(
            ['event_id' => $event->id],
            $data
        );


        // Handle gallery upload
        if ($request->hasFile('galleries')) {
            foreach ($request->file('galleries') as $index => $file) {
                $path = $file->store("events/{$event->id}/gallery", 'public');
                InvitationGallery::create([
                    'event_id' => $event->id,
                    'photo' => $path,
                    'order' => $event->invitationGalleries()->count() + $index,
                ]);
            }
        }

        return back()->with('success', 'Konten undangan berhasil disimpan.');
    }

    public function destroyGallery(Event $event, InvitationGallery $gallery)
    {
        $gallery->delete();
        return back()->with('success', 'Foto berhasil dihapus.');
    }

}