<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\User;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index(Request $request)
    {
        $competitions = Competition::with('user')
            ->when(
                $request->search,
                fn($q) =>
                $q->where('title', 'like', "%{$request->search}%")
            )
            ->when(
                $request->kategori,
                fn($q) =>
                $q->where('category', $request->kategori)
            )
            ->when(
                $request->sort == 'deadline',
                fn($q) =>
                $q->orderBy('deadline', 'asc'),
                fn($q) =>
                $q->latest()
            )
            ->paginate(12);

        return view('competitions.index', [
            'competitions' => $competitions,
            'totalCompetitions' => Competition::count(),
            'totalUsers' => User::count(),
        ]);
    }

    public function create()
    {
        return view('competitions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'deadline' => 'required|date',
            'poster' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')
                ->store('posters', 'public');
        }

        $validated['user_id'] = auth()->id();

        Competition::create($validated);

        return redirect()->route('competitions.index')
            ->with('success', 'Lomba berhasil ditambahkan!');
    }

    public function show(Competition $competition)
    {
        return view('competitions.show', compact('competition'));
    }

    public function edit(Competition $competition)
    {
        return view('competitions.edit', compact('competition'));
    }

    public function update(Request $request, Competition $competition)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'deadline' => 'required|date',
            'poster' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('poster')) {
            $validated['poster'] = $request->file('poster')
                ->store('posters', 'public');
        }

        $competition->update($validated);

        return redirect()->route('competitions.show', $competition->id)
            ->with('success', 'Kompetisi berhasil diperbarui!');
    }

    public function destroy(Competition $competition)
    {
        $competition->delete();

        return redirect()->route('competitions.index')
            ->with('success', 'Kompetisi berhasil dihapus.');
    }
}