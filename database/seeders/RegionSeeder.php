<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $regions = [
            ['name' => ['sr' => 'Beograd', 'en' => 'Belgrade', 'ru' => 'Белград'], 'slug' => 'beograd', 'sort_order' => 1],
            ['name' => ['sr' => 'Novi Sad', 'en' => 'Novi Sad', 'ru' => 'Нови-Сад'], 'slug' => 'novi-sad', 'sort_order' => 2],
            ['name' => ['sr' => 'Niš', 'en' => 'Niš', 'ru' => 'Ниш'], 'slug' => 'nis', 'sort_order' => 3],
            ['name' => ['sr' => 'Kragujevac', 'en' => 'Kragujevac', 'ru' => 'Крагуевац'], 'slug' => 'kragujevac', 'sort_order' => 4],
            ['name' => ['sr' => 'Subotica', 'en' => 'Subotica', 'ru' => 'Суботица'], 'slug' => 'subotica', 'sort_order' => 5],
            ['name' => ['sr' => 'Zrenjanin', 'en' => 'Zrenjanin', 'ru' => 'Зренянин'], 'slug' => 'zrenjanin', 'sort_order' => 6],
            ['name' => ['sr' => 'Pančevo', 'en' => 'Pančevo', 'ru' => 'Панчево'], 'slug' => 'pancevo', 'sort_order' => 7],
            ['name' => ['sr' => 'Čačak', 'en' => 'Čačak', 'ru' => 'Чачак'], 'slug' => 'cacak', 'sort_order' => 8],
            ['name' => ['sr' => 'Kraljevo', 'en' => 'Kraljevo', 'ru' => 'Кралево'], 'slug' => 'kraljevo', 'sort_order' => 9],
            ['name' => ['sr' => 'Smederevo', 'en' => 'Smederevo', 'ru' => 'Смедерево'], 'slug' => 'smederevo', 'sort_order' => 10],
            ['name' => ['sr' => 'Leskovac', 'en' => 'Leskovac', 'ru' => 'Лесковац'], 'slug' => 'leskovac', 'sort_order' => 11],
            ['name' => ['sr' => 'Valjevo', 'en' => 'Valjevo', 'ru' => 'Валево'], 'slug' => 'valjevo', 'sort_order' => 12],
        ];

        foreach ($regions as $region) {
            Region::create($region);
        }
    }
}
