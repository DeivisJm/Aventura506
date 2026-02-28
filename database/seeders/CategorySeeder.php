<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Nature', 'slug' => 'nature'],
            ['name' => 'Water', 'slug' => 'water'],
            ['name' => 'Horseback Riding', 'slug' => 'horseback'],
            ['name' => 'Vehicles', 'slug' => 'vehicles'],
            ['name' => 'Adventure', 'slug' => 'adventure'],
            ['name' => 'Extreme', 'slug' => 'extreme'],
        ];

        foreach ($categories as $category) {

            Category::updateOrCreate(
                ['slug' => $category['slug']], // unique field
                $category
            );
        }
    }
}
