<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            'UI/UX Designer',
            'Frontend Developer',
            'Backend Developer',
            'Mobile Developer',
            'Data Scientist',
            'Quality Assurance',
            'Project Manager',
            'DevOps Engineer'
        ];

        foreach ($skills as $skillName) {
            // updateOrCreate supaya tidak double jika seeder dijalankan ulang
            Skill::updateOrCreate(
                ['name' => $skillName],
                ['slug' => Str::slug($skillName)]
            );
        }
    }
}