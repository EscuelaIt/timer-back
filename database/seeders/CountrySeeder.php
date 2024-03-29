<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'Argentina', 'slug' => 'argentina', 'continent' => 'South America'],
            ['name' => 'Australia', 'slug' => 'australia', 'continent' => 'Oceania'],
            ['name' => 'Belgium', 'slug' => 'belgium', 'continent' => 'Europe'],
            ['name' => 'Brazil', 'slug' => 'brazil', 'continent' => 'South America'],
            ['name' => 'Canada', 'slug' => 'canada', 'continent' => 'North America'],
            ['name' => 'China', 'slug' => 'china', 'continent' => 'Asia'],
            ['name' => 'Denmark', 'slug' => 'denmark', 'continent' => 'Europe'],
            ['name' => 'Egypt', 'slug' => 'egypt', 'continent' => 'Africa'],
            ['name' => 'France', 'slug' => 'france', 'continent' => 'Europe'],
            ['name' => 'Germany', 'slug' => 'germany', 'continent' => 'Europe'],
            ['name' => 'Greece', 'slug' => 'greece', 'continent' => 'Europe'],
            ['name' => 'India', 'slug' => 'india', 'continent' => 'Asia'],
            ['name' => 'Italy', 'slug' => 'italy', 'continent' => 'Europe'],
            ['name' => 'Japan', 'slug' => 'japan', 'continent' => 'Asia'],
            ['name' => 'Kenya', 'slug' => 'kenya', 'continent' => 'Africa'],
            ['name' => 'Mexico', 'slug' => 'mexico', 'continent' => 'North America'],
            ['name' => 'Netherlands', 'slug' => 'netherlands', 'continent' => 'Europe'],
            ['name' => 'Norway', 'slug' => 'norway', 'continent' => 'Europe'],
            ['name' => 'Peru', 'slug' => 'peru', 'continent' => 'South America'],
            ['name' => 'Russia', 'slug' => 'russia', 'continent' => 'Europe/Asia'],
            ['name' => 'South Africa', 'slug' => 'south-africa', 'continent' => 'Africa'],
            ['name' => 'Spain', 'slug' => 'spain', 'continent' => 'Europe'],
            ['name' => 'Sweden', 'slug' => 'sweden', 'continent' => 'Europe'],
            ['name' => 'Switzerland', 'slug' => 'switzerland', 'continent' => 'Europe'],
            ['name' => 'Thailand', 'slug' => 'thailand', 'continent' => 'Asia'],
            ['name' => 'Turkey', 'slug' => 'turkey', 'continent' => 'Europe/Asia'],
            ['name' => 'United Kingdom', 'slug' => 'united-kingdom', 'continent' => 'Europe'],
            ['name' => 'United States', 'slug' => 'united-states', 'continent' => 'North America'],
            ['name' => 'Vietnam', 'slug' => 'vietnam', 'continent' => 'Asia'],
            ['name' => 'Zimbabwe', 'slug' => 'zimbabwe', 'continent' => 'Africa']
        ];

        foreach ($countries as $country) {
            DB::table('countries')->insert([
                'name' => $country['name'],
                'slug' => $country['slug'],
                'continent' => $country['continent'],
            ]);
        }
    }
}
