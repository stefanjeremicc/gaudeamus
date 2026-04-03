<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $skills = [
            // IT
            ['name' => ['sr' => 'PHP', 'en' => 'PHP', 'ru' => 'PHP'], 'slug' => 'php', 'category' => 'IT'],
            ['name' => ['sr' => 'JavaScript', 'en' => 'JavaScript', 'ru' => 'JavaScript'], 'slug' => 'javascript', 'category' => 'IT'],
            ['name' => ['sr' => 'Python', 'en' => 'Python', 'ru' => 'Python'], 'slug' => 'python', 'category' => 'IT'],
            ['name' => ['sr' => 'React', 'en' => 'React', 'ru' => 'React'], 'slug' => 'react', 'category' => 'IT'],
            ['name' => ['sr' => 'WordPress', 'en' => 'WordPress', 'ru' => 'WordPress'], 'slug' => 'wordpress', 'category' => 'IT'],
            ['name' => ['sr' => 'Excel', 'en' => 'Excel', 'ru' => 'Excel'], 'slug' => 'excel', 'category' => 'Office'],
            ['name' => ['sr' => 'Photoshop', 'en' => 'Photoshop', 'ru' => 'Photoshop'], 'slug' => 'photoshop', 'category' => 'Design'],
            // General
            ['name' => ['sr' => 'Komunikacija', 'en' => 'Communication', 'ru' => 'Коммуникация'], 'slug' => 'komunikacija', 'category' => 'Soft Skills'],
            ['name' => ['sr' => 'Timski rad', 'en' => 'Teamwork', 'ru' => 'Командная работа'], 'slug' => 'timski-rad', 'category' => 'Soft Skills'],
            ['name' => ['sr' => 'Engleski jezik', 'en' => 'English Language', 'ru' => 'Английский язык'], 'slug' => 'engleski-jezik', 'category' => 'Languages'],
            ['name' => ['sr' => 'Vozačka dozvola B', 'en' => 'Driving License B', 'ru' => 'Водительские права B'], 'slug' => 'vozacka-b', 'category' => 'Other'],
            ['name' => ['sr' => 'Rad sa kasama', 'en' => 'Cash Register', 'ru' => 'Работа с кассой'], 'slug' => 'rad-sa-kasama', 'category' => 'Retail'],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }
    }
}
