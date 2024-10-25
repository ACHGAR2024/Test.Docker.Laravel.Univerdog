<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    // Method to retrieve all categories
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return response()->json(['categories' => $categories]);
    }

    // Method to create a new category
    public function store(Request $request)
    {
        // Check that the user is an administrator
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate the request data
        $request->validate([
            'name_cat' => 'required|string|max:255'
        ]);

        // Create the category
        $category = Category::create($request->all());

        return response()->json(['category' => $category, 'message' => 'Category created successfully']);
    }

    // Method to display a specific category
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return response()->json(['category' => $category]);
    }

    // Method to update a category
    public function update(Request $request, $id)
    {
        // Check that the user is an administrator
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate the request data
        $request->validate([
            'name_cat' => 'required|string|max:255'
        ]);

        // Update the category
        $category = Category::findOrFail($id);
        $category->update($request->all());

        return response()->json(['category' => $category, 'message' => 'Category updated successfully']);
    }

    // Method to delete a category
    public function destroy($id)
    {
        // Check that the user is an administrator
        if (Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully']);
    }
}