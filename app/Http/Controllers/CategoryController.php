<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function index() {
        // List all categories
        return Category::all();
    }

    public function store(Request $request) {
        // Create a new category
    }

    public function update(Request $request, $id) {
        // Edit a category
    }

    public function destroy($id) {
        // Delete a category
    }
}
