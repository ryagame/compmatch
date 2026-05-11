<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompetitionController;
use App\Http\Controllers\LobbyController;
use App\Http\Controllers\SkillSlotController;

Route::get('/', function () {
    return redirect()->route('competitions.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::patch('/profile/skills', [ProfileController::class, 'updateSkills'])->name('profile.skills.update');
    
    // Competition
    Route::resource('competitions', CompetitionController::class);

    // Lobby (nested di bawah competition)
    Route::resource('competitions.lobbies', LobbyController::class);

    // Skill Slot (nested di bawah lobby)
    Route::resource('lobbies.skill-slots', SkillSlotController::class);

    // Take & Release Skill Slot
    Route::post('lobbies/{lobby}/skill-slots/{skillSlot}/take', [SkillSlotController::class, 'take'])
         ->name('lobbies.skill-slots.take');
    Route::delete('lobbies/{lobby}/skill-slots/{skillSlot}/release', [SkillSlotController::class, 'release'])
        ->name('lobbies.skill-slots.release');
    
    // Join & Leave Lobby
    Route::post('competitions/{competition}/lobbies/{lobby}/join', [LobbyController::class, 'join'])
        ->name('competitions.lobbies.join');
    Route::delete('competitions/{competition}/lobbies/{lobby}/leave', [LobbyController::class, 'leave'])
        ->name('competitions.lobbies.leave');

    // Matchmaking
    Route::post('competitions/{competition}/lobbies/{lobby}/matchmaking', [LobbyController::class, 'matchmaking'])
        ->name('competitions.lobbies.matchmaking');

    Route::post('competitions/{competition}/lobbies/{lobby}/reset-matchmaking', [LobbyController::class, 'resetMatchmaking'])
        ->name('competitions.lobbies.resetMatchmaking');

    // Skill Slot (nested di bawah lobby)
    Route::resource('lobbies.skill-slots', SkillSlotController::class);
});

require __DIR__.'/auth.php';