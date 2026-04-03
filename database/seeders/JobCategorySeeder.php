<?php

namespace Database\Seeders;

use App\Models\JobCategory;
use Illuminate\Database\Seeder;

class JobCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => ['sr' => 'IT i Programiranje', 'en' => 'IT & Programming', 'ru' => 'IT и программирование'], 'slug' => 'it-programiranje', 'icon' => '💻', 'sort_order' => 1],
            ['name' => ['sr' => 'Ugostiteljstvo', 'en' => 'Hospitality', 'ru' => 'Гостиничный бизнес'], 'slug' => 'ugostiteljstvo', 'icon' => '🍽️', 'sort_order' => 2],
            ['name' => ['sr' => 'Marketing i Prodaja', 'en' => 'Marketing & Sales', 'ru' => 'Маркетинг и продажи'], 'slug' => 'marketing-prodaja', 'icon' => '📊', 'sort_order' => 3],
            ['name' => ['sr' => 'Magacin i Logistika', 'en' => 'Warehouse & Logistics', 'ru' => 'Склад и логистика'], 'slug' => 'magacin-logistika', 'icon' => '📦', 'sort_order' => 4],
            ['name' => ['sr' => 'Pozivni Centar', 'en' => 'Call Center', 'ru' => 'Колл-центр'], 'slug' => 'pozivni-centar', 'icon' => '📞', 'sort_order' => 5],
            ['name' => ['sr' => 'Administracija', 'en' => 'Administration', 'ru' => 'Администрация'], 'slug' => 'administracija', 'icon' => '🗂️', 'sort_order' => 6],
            ['name' => ['sr' => 'Fizički Poslovi', 'en' => 'Physical Work', 'ru' => 'Физическая работа'], 'slug' => 'fizicki-poslovi', 'icon' => '🏗️', 'sort_order' => 7],
            ['name' => ['sr' => 'Edukacija i Obuka', 'en' => 'Education & Training', 'ru' => 'Образование'], 'slug' => 'edukacija-obuka', 'icon' => '🎓', 'sort_order' => 8],
            ['name' => ['sr' => 'Dizajn i Kreativa', 'en' => 'Design & Creative', 'ru' => 'Дизайн и креатив'], 'slug' => 'dizajn-kreativa', 'icon' => '🎨', 'sort_order' => 9],
            ['name' => ['sr' => 'Promoteri i Hostese', 'en' => 'Promoters & Hosts', 'ru' => 'Промоутеры и хостес'], 'slug' => 'promoteri-hostese', 'icon' => '🎤', 'sort_order' => 10],
            ['name' => ['sr' => 'Trgovina', 'en' => 'Retail', 'ru' => 'Торговля'], 'slug' => 'trgovina', 'icon' => '🛒', 'sort_order' => 11],
            ['name' => ['sr' => 'Ostalo', 'en' => 'Other', 'ru' => 'Другое'], 'slug' => 'ostalo', 'icon' => '📋', 'sort_order' => 12],
        ];

        foreach ($categories as $category) {
            JobCategory::create($category);
        }
    }
}
