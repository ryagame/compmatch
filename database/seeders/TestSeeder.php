<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Competition;
use App\Models\Lobby;
use App\Models\LobbyMember;
use App\Models\SkillSlot;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        // Buat 4 user dummy
        $user1 = User::create([
            'name'              => 'Alice',
            'email'             => 'alice@test.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $user2 = User::create([
            'name'              => 'Bob',
            'email'             => 'bob@test.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $user3 = User::create([
            'name'              => 'Charlie',
            'email'             => 'charlie@test.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $user4 = User::create([
            'name'              => 'Diana',
            'email'             => 'diana@test.com',
            'password'          => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Buat kompetisi milik Alice
        $competition = Competition::create([
            'user_id'     => $user1->id,
            'title'       => 'Hackathon 2026',
            'description' => 'Kompetisi hackathon tingkat nasional',
            'category'    => 'Teknologi',
            'deadline'    => '2026-12-31',
            'poster'      => null,
        ]);

        // Buat lobby milik Alice
        $lobby = Lobby::create([
            'competition_id' => $competition->id,
            'user_id'        => $user1->id,
            'name'           => 'Tim Alpha',
            'max_members'    => 4,
        ]);

        // Tambah anggota (Bob, Charlie, Diana join)
        LobbyMember::create(['lobby_id' => $lobby->id, 'user_id' => $user2->id]);
        LobbyMember::create(['lobby_id' => $lobby->id, 'user_id' => $user3->id]);
        LobbyMember::create(['lobby_id' => $lobby->id, 'user_id' => $user4->id]);

        // Tambah skill slot (semua kosong)
        SkillSlot::create(['lobby_id' => $lobby->id, 'skill_name' => 'Frontend Developer', 'filled_by' => null]);
        SkillSlot::create(['lobby_id' => $lobby->id, 'skill_name' => 'Backend Developer',  'filled_by' => null]);
        SkillSlot::create(['lobby_id' => $lobby->id, 'skill_name' => 'UI Designer',        'filled_by' => null]);
    }
}