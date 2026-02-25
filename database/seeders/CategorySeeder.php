<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::insert([
            [
                'name' => 'Nature',
                'slug' => 'nature',
            ],
            [
                'name' => 'Water',
                'slug' => 'water',
            ],
            [
                'name' => 'Horseback Riding',
                'slug' => 'horseback',
            ],
            [
                'name' => 'Vehicles',
                'slug' => 'vehicles',
            ],
            [
                'name' => 'Adventure',
                'slug' => 'adventure',
            ],
            [
                'name' => 'Extreme',
                'slug' => 'extreme',
            ],
        ]);
    }
}
