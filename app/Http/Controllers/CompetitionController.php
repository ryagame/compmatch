<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetitionController extends Controller
{
    public function index(Request $request)
{
    $query = Competition::with('user')->latest();

    // Search
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('description', 'like', '%' . $request->search . '%');
    }

    // Filter kategori
    if ($request->filled('category')) {
        $query->where('category', $request->category);
    }

    $competitions = $query->get();
    $categories   = Competition::distinct()->pluck('category');

    return view('competitions.index', compact('competitions', 'categories'));
}

    public function create()
    {
        return view('competitions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category'    => 'required|string|max:255',
            'deadline'    => 'required|date',
            'poster'      => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'category', 'deadline']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        Competition::create($data);

        return redirect()->route('competitions.index')
            ->with('success', 'Lomba berhasil ditambahkan!');
    }

    public function show(Competition $competition)
    {
        $competition->load('lobbies.members', 'lobbies.skillSlots');
        return view('competitions.show', compact('competition'));
    }

    public function edit(Competition $competition)
    {
        return view('competitions.edit', compact('competition'));
    }

    public function update(Request $request, Competition $competition)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'category'    => 'required|string|max:255',
            'deadline'    => 'required|date',
            'poster'      => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['title', 'description', 'category', 'deadline']);

        if ($request->hasFile('poster')) {
            $data['poster'] = $request->file('poster')->store('posters', 'public');
        }

        $competition->update($data);

        return redirect()->route('competitions.index')
            ->with('success', 'Lomba berhasil diperbarui!');
    }

    public function destroy(Competition $competition)
    {
        $competition->delete();
        return redirect()->route('competitions.index')
            ->with('success', 'Lomba berhasil dihapus!');
    }
}