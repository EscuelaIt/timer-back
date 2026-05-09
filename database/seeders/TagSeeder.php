<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            'Strategy',
            'Family game',
            'Party game',
            'Casual game',
            'Experts',
            'Abstract',
        ];

        $now = Carbon::now();

        DB::table('tags')->insert(
            collect($tags)->map(fn ($name) => [
                'name' => $name,
                'slug' => Str::slug($name),
                'created_at' => $now,
                'updated_at' => $now,
            ])->toArray()
        );
    }
}
