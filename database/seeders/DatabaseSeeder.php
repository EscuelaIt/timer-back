<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Database\Seeders\CountrySeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\MechanicSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Miguel',
            'email' => 'miguel@example.com',
            'password' => Hash::make('1234qwer'),
        ]);
        \App\Models\User::create([
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => Hash::make('secret1234'),
        ]);

        $this->call(CategorySeeder::class);

        $this->call(CountrySeeder::class);

        $this->call(BoardGamesSeeder::class);

        $this->call(MechanicSeeder::class);
    }
}
