<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Lobby;
use App\Models\LobbyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LobbyController extends Controller
{
    public function index(Competition $competition)
    {
        $lobbies = $competition->lobbies()->withCount('members')->get();
        return view('lobbies.index', compact('competition', 'lobbies'));
    }

    public function create(Competition $competition)
    {
        return view('lobbies.create', compact('competition'));
    }

    public function store(Request $request, Competition $competition)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'max_members' => 'required|integer|min:2|max:20',
        ]);

        $competition->lobbies()->create([
            'user_id'     => Auth::id(),
            'name'        => $request->name,
            'max_members' => $request->max_members,
        ]);

        return redirect()
            ->route('competitions.show', $competition)
            ->with('success', 'Lobby berhasil dibuat!');
    }

   public function show(Competition $competition, Lobby $lobby)
{
    $isOwner = auth()->id() === $lobby->user_id;

    $isMember = $lobby->members()
        ->where('user_id', auth()->id())
        ->exists();

    return view('lobbies.show', compact(
        'competition',
        'lobby',
        'isOwner',
        'isMember'
    ));
}

    public function edit(Competition $competition, Lobby $lobby)
    {
        if ($lobby->user_id !== Auth::id()) {
            abort(403);
        }

        return view('lobbies.edit', compact('competition', 'lobby'));
    }

    public function update(Request $request, Competition $competition, Lobby $lobby)
    {
        if ($lobby->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'max_members' => 'required|integer|min:2|max:20',
        ]);

        $lobby->update([
            'name'        => $request->name,
            'max_members' => $request->max_members,
        ]);

        return redirect()
            ->route('competitions.lobbies.show', [$competition, $lobby])
            ->with('success', 'Lobby berhasil diupdate!');
    }

    public function destroy(Competition $competition, Lobby $lobby)
    {
        if ($lobby->user_id !== Auth::id()) {
            abort(403);
        }

        $lobby->delete();

        return redirect()
            ->route('competitions.show', $competition)
            ->with('success', 'Lobby berhasil dihapus!');
    }

    public function join(Competition $competition, Lobby $lobby)
    {
        if ($lobby->members()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Kamu sudah bergabung di lobby ini!');
        }

        if ($lobby->members()->count() >= $lobby->max_members) {
            return back()->with('error', 'Lobby sudah penuh!');
        }

        $lobby->members()->create(['user_id' => Auth::id()]);

        return back()->with('success', 'Berhasil bergabung ke lobby!');
    }

    public function leave(Competition $competition, Lobby $lobby)
    {
        $lobby->members()->where('user_id', Auth::id())->delete();

        return back()->with('success', 'Kamu keluar dari lobby.');
    }

    // Matchmaking otomatis
    public function matchmaking(Competition $competition, Lobby $lobby)
    {
        if ($lobby->user_id !== Auth::id()) {
            abort(403);
        }

        $lobby->load('members.user', 'skillSlots');

        // Ambil slot yang masih kosong
        $emptySlots = $lobby->skillSlots->whereNull('filled_by')->values();

        if ($emptySlots->isEmpty()) {
            return back()->with('error', 'Semua slot sudah terisi, matchmaking tidak diperlukan!');
        }

        // Ambil anggota yang belum mengisi slot manapun
        $filledUserIds = $lobby->skillSlots->pluck('filled_by')->filter()->values();
        $unmatchedMembers = $lobby->members
            ->whereNotIn('user_id', $filledUserIds)
            ->where('user_id', '!=', $lobby->user_id) // owner tidak diassign
            ->values();

        if ($unmatchedMembers->isEmpty()) {
            return back()->with('error', 'Semua anggota sudah memiliki slot!');
        }

        // Assign anggota ke slot secara acak
        $shuffledMembers = $unmatchedMembers->shuffle();
        $assigned = 0;

        foreach ($emptySlots as $index => $slot) {
            if (!isset($shuffledMembers[$index])) break;

            $slot->update(['filled_by' => $shuffledMembers[$index]->user_id]);
            $assigned++;
        }

        return back()->with('success', "Matchmaking selesai! $assigned anggota berhasil di-assign ke slot.");
    }

    // Reset Matchmaking
public function resetMatchmaking(Competition $competition, Lobby $lobby)
{
    if ($lobby->user_id !== Auth::id()) {
        abort(403);
    }

    $lobby->skillSlots()->update(['filled_by' => null]);

    return back()->with('success', 'Semua slot berhasil dikosongkan!');
}
}