<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryNames = [
            "Programación",
            "Pruebas",
            "Gestión",
            "Presupuestos",
            "Despliegue",
        ];

        foreach ($categoryNames as $categoryName) {
            Category::factory()->create([
                'name' => $categoryName,
                'user_id' => 1,
            ]);
        }

        foreach ($categoryNames as $categoryName) {
            Category::factory()->create([
                'name' => $categoryName,
                'user_id' => 2,
            ]);
        }
    }
}
