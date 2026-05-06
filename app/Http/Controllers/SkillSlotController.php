<?php

namespace App\Http\Controllers;

use App\Models\Lobby;
use App\Models\SkillSlot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillSlotController extends Controller
{
    public function create(Lobby $lobby)
    {
        // Hanya owner lobby yang boleh tambah slot
        if ($lobby->user_id !== Auth::id()) {
            abort(403);
        }

        return view('skill-slots.create', compact('lobby'));
    }

    public function store(Request $request, Lobby $lobby)
    {
        if ($lobby->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'skill_name' => 'required|string|max:255',
        ]);

        $lobby->skillSlots()->create([
            'skill_name' => $request->skill_name,
            'filled_by'  => null,
        ]);

        return redirect()
            ->route('competitions.lobbies.show', [$lobby->competition_id, $lobby])
            ->with('success', 'Skill slot berhasil ditambahkan!');
    }

    public function destroy(Lobby $lobby, SkillSlot $skillSlot)
    {
        if ($lobby->user_id !== Auth::id()) {
            abort(403);
        }

        $skillSlot->delete();

        return redirect()
            ->route('competitions.lobbies.show', [$lobby->competition_id, $lobby])
            ->with('success', 'Skill slot berhasil dihapus!');
    }

    // Fitur: ambil skill slot (user assign dirinya ke slot)
    public function take(Lobby $lobby, SkillSlot $skillSlot)
    {
        // Harus jadi member lobby dulu
        $isMember = $lobby->members()->where('user_id', Auth::id())->exists();
        if (!$isMember) {
            return back()->with('error', 'Kamu harus bergabung ke lobby dulu!');
        }

        // Slot sudah diambil orang lain
        if ($skillSlot->filled_by !== null) {
            return back()->with('error', 'Slot ini sudah diambil!');
        }

        $skillSlot->update(['filled_by' => Auth::id()]);

        return back()->with('success', 'Kamu mengambil slot ' . $skillSlot->skill_name . '!');
    }

    // Fitur: lepas skill slot
    public function release(Lobby $lobby, SkillSlot $skillSlot)
    {
        if ($skillSlot->filled_by !== Auth::id()) {
            abort(403);
        }

        $skillSlot->update(['filled_by' => null]);

        return back()->with('success', 'Slot berhasil dilepas.');
    }
}