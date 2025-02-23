<?php

namespace App\Http\Controllers;

use App\Models\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    /**
     * Display a listing of the speakers.
     */
    public function index()
    {
        $speakers = Speaker::all();
        return view('speakers.index', compact('speakers'));
    }

    /**
     * Show the form for creating a new speaker.
     */
    public function create()
    {
        return view('speakers.create');
    }

    /**
     * Store a newly created speaker in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $speaker = Speaker::create($validated);

        if ($request->hasFile('avatar')) {
            $speaker->addMediaFromRequest('avatar')->toMediaCollection('photo');
        }

        return redirect()->route('speakers.index')->with('success', 'Speaker created successfully.');
    }

    /**
     * Display the specified speaker.
     */
    public function show(Speaker $speaker)
    {
        return view('speakers.show', compact('speaker'));
    }

    /**
     * Show the form for editing the specified speaker.
     */
    public function edit(Speaker $speaker)
    {
        return view('speakers.edit', compact('speaker'));
    }

    /**
     * Update the specified speaker in storage.
     */
    public function update(Request $request, Speaker $speaker)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'avatar' => 'nullable|image|max:2048',
        ]);

        $speaker->update($validated);

        if ($request->hasFile('avatar')) {
            $speaker->clearMediaCollection('photo');
            $speaker->addMediaFromRequest('avatar')->toMediaCollection('photo');
        }

        return redirect()->route('speakers.index')->with('success', 'Speaker updated successfully.');
    }

    /**
     * Remove the specified speaker from storage.
     */
    public function destroy(Speaker $speaker)
    {
        $speaker->clearMediaCollection('photo');
        $speaker->delete();

        return redirect()->route('speakers.index')->with('success', 'Speaker deleted successfully.');
    }
}
