<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 6; $i <= 56; $i++) {
            $name = fake()->name();
            Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'image' => fake()->imageUrl(),
                'parent_id' => random_int(6, 56),
            ]);
        }
    }
}
