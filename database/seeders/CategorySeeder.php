<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (['Chopper', 'Cafe Racer', 'Bobber', 'Scrambler', 'Tracker', 'Restoration'] as $n) {
            Category::firstOrCreate(['slug' => \Str::slug($n)], ['name' => $n]);
        }
    }
}
