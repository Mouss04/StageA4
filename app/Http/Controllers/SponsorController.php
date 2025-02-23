<?php

namespace App\Http\Controllers;

use App\Models\Sponsor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SponsorController extends Controller
{
    /**
     * Display a listing of sponsors.
     */
    public function index()
    {
        $sponsors = Sponsor::paginate(10);
        return view('sponsors.index', compact('sponsors'));
    }

    /**
     * Show the form for creating a new sponsor.
     */
    public function create()
    {
        return view('sponsors.create');
    }

    /**
     * Store a newly created sponsor.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'files' => 'nullable|file|max:5120',
        ]);

        $sponsor = Sponsor::create($request->only(['name', 'description', 'category']));

        // Upload logo
        if ($request->hasFile('logo')) {
            $sponsor->addMedia($request->file('logo'))->toMediaCollection('logo');
        }

        // Upload additional files
        if ($request->hasFile('files')) {
            $sponsor->addMedia($request->file('files'))->toMediaCollection('sponsors');
        }

        return redirect()->route('sponsors.index')->with('success', 'Sponsor created successfully!');
    }

    /**
     * Display the specified sponsor.
     */
    public function show(Sponsor $sponsor)
    {
        return view('sponsors.show', compact('sponsor'));
    }

    /**
     * Show the form for editing the specified sponsor.
     */
    public function edit(Sponsor $sponsor)
    {
        return view('sponsors.edit', compact('sponsor'));
    }

    /**
     * Update the specified sponsor.
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'files' => 'nullable|file|max:5120',
        ]);

        $sponsor->update($request->only(['name', 'description', 'category']));

        // Update logo if new one is uploaded
        if ($request->hasFile('logo')) {
            $sponsor->clearMediaCollection('logo');
            $sponsor->addMedia($request->file('logo'))->toMediaCollection('logo');
        }

        // Update files if new one is uploaded
        if ($request->hasFile('files')) {
            $sponsor->clearMediaCollection('sponsors');
            $sponsor->addMedia($request->file('files'))->toMediaCollection('sponsors');
        }

        return redirect()->route('sponsors.index')->with('success', 'Sponsor updated successfully!');
    }

    /**
     * Remove the specified sponsor.
     */
    public function destroy(Sponsor $sponsor)
    {
        $sponsor->clearMediaCollection(); // Remove all media
        $sponsor->delete();

        return redirect()->route('sponsors.index')->with('success', 'Sponsor deleted successfully!');
    }
}
