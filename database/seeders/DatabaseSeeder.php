<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->count(10)->create();
        product::factory()->count(10)->create();
        category::factory()->count(10)->create();

        $categories = Category::all();
        // Loop through all products
        Product::all()->each(function ($product) use ($categories) {
            $randomCategories = $categories->random(rand(1, 3))->pluck('id');
            $product->categories()->sync($randomCategories);
        });




    }
}
