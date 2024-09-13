<?php

namespace App\Traits;
use Illuminate\Support\Str;
use App\Models\Product;

trait SlugTrait
{
    //
    function createUniqueSlug($username)
{
    // Step 1: Create a base slug using Str::slug
    $slug = Str::slug($username);

    // Step 2: Check if the slug already exists in the 'users' table
    $originalSlug = $slug;
    $count = 1;

    while (Product::where('slug', $slug)->exists()) {
        // Step 3: Append a number if the slug exists
        $slug = $originalSlug . '-' . $count;
        $count++;
    }

    // Step 4: Return the unique slug
    return $slug;
}
}
