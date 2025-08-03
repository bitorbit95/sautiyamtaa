<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProgramController extends Controller
{
    /**
     * Display a listing of the programs.
     */
    public function index(Request $request): View
    {
        $query = Program::active()->ordered();

        // Filter by status if provided
        if ($request->has('status') && in_array($request->status, ['upcoming', 'ongoing', 'completed'])) {
            switch ($request->status) {
                case 'upcoming':
                    $query->whereDate('start_date', '>', now());
                    break;
                case 'ongoing':
                    $query->whereDate('start_date', '<=', now())
                          ->whereDate('end_date', '>=', now());
                    break;
                case 'completed':
                    $query->whereDate('end_date', '<', now());
                    break;
            }
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('title_sw', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhere('description_sw', 'like', "%{$searchTerm}%");
            });
        }

        $programs = $query->paginate(12);
        $featuredPrograms = Program::active()->featured()->ordered()->limit(3)->get();

        return view('programs.index', compact('programs', 'featuredPrograms'));
    }

    /**
     * Display the specified program.
     */
    public function show(Program $program): View
    {
        // Check if program is active
        if ($program->status !== 'active') {
            abort(404);
        }

        // Get related programs (same location or similar)
        $relatedPrograms = Program::active()
            ->where('id', '!=', $program->id)
            ->where(function ($query) use ($program) {
                $query->where('location', $program->location)
                      ->orWhere('location_sw', $program->location_sw);
            })
            ->ordered()
            ->limit(3)
            ->get();

        // If no related programs found, get any other active programs
        if ($relatedPrograms->count() < 3) {
            $additionalPrograms = Program::active()
                ->where('id', '!=', $program->id)
                ->whereNotIn('id', $relatedPrograms->pluck('id'))
                ->ordered()
                ->limit(3 - $relatedPrograms->count())
                ->get();

            $relatedPrograms = $relatedPrograms->merge($additionalPrograms);
        }

        return view('programs.show', compact('program', 'relatedPrograms'));
    }

    /**
     * Show the form for creating a new program (Admin only).
     */
    public function create(): View
    {
        return view('admin.programs.create');
    }

    /**
     * Store a newly created program (Admin only).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_sw' => 'nullable|string|max:255',
            'description' => 'required|string',
            'description_sw' => 'nullable|string',
            'full_description' => 'nullable|string',
            'full_description_sw' => 'nullable|string',
            'duration' => 'required|string|max:255',
            'duration_sw' => 'nullable|string|max:255',
            'participants' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,draft',
            'sort_order' => 'required|integer|min:0',
            'objectives' => 'nullable|array',
            'requirements' => 'nullable|array',
            'location' => 'nullable|string|max:255',
            'location_sw' => 'nullable|string|max:255',
            'cost' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_featured' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('programs', 'public');
        }

        // Handle gallery upload
        if ($request->hasFile('gallery')) {
            $galleryImages = [];
            foreach ($request->file('gallery') as $file) {
                $galleryImages[] = $file->store('programs/gallery', 'public');
            }
            $validated['gallery'] = $galleryImages;
        }

        $program = Program::create($validated);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program created successfully.');
    }

    /**
     * Show the form for editing the specified program (Admin only).
     */
    public function edit(Program $program): View
    {
        return view('admin.programs.edit', compact('program'));
    }

    /**
     * Update the specified program (Admin only).
     */
    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'title_sw' => 'nullable|string|max:255',
            'description' => 'required|string',
            'description_sw' => 'nullable|string',
            'full_description' => 'nullable|string',
            'full_description_sw' => 'nullable|string',
            'duration' => 'required|string|max:255',
            'duration_sw' => 'nullable|string|max:255',
            'participants' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive,draft',
            'sort_order' => 'required|integer|min:0',
            'objectives' => 'nullable|array',
            'requirements' => 'nullable|array',
            'location' => 'nullable|string|max:255',
            'location_sw' => 'nullable|string|max:255',
            'cost' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_featured' => 'boolean'
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($program->image) {
                \Storage::disk('public')->delete($program->image);
            }
            $validated['image'] = $request->file('image')->store('programs', 'public');
        }

        // Handle gallery upload
        if ($request->hasFile('gallery')) {
            // Delete old gallery images
            if ($program->gallery) {
                foreach ($program->gallery as $image) {
                    \Storage::disk('public')->delete($image);
                }
            }
            
            $galleryImages = [];
            foreach ($request->file('gallery') as $file) {
                $galleryImages[] = $file->store('programs/gallery', 'public');
            }
            $validated['gallery'] = $galleryImages;
        }

        $program->update($validated);

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program updated successfully.');
    }

    /**
     * Remove the specified program (Admin only).
     */
    public function destroy(Program $program)
    {
        // Delete associated images
        if ($program->image) {
            \Storage::disk('public')->delete($program->image);
        }

        if ($program->gallery) {
            foreach ($program->gallery as $image) {
                \Storage::disk('public')->delete($image);
            }
        }

        $program->delete();

        return redirect()->route('admin.programs.index')
            ->with('success', 'Program deleted successfully.');
    }
}