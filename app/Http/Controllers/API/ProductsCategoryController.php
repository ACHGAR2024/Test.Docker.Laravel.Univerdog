<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductsCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductsCategoryController extends Controller
{
    /**
     * Display a listing of the product categories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ProductsCategory::all();
        return response()->json($categories);
    }

    /**
     * Store a newly created product category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_product_cat' => 'required|string|max:100',
        ]);

        $category = ProductsCategory::create($validatedData);
        return response()->json($category, Response::HTTP_CREATED);
    }

    /**
     * Display the specified product category.
     *
     * @param  \App\Models\ProductsCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(ProductsCategory $category)
    {
        return response()->json($category);
    }

    /**
     * Update the specified product category in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductsCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductsCategory $category)
    {
        $validatedData = $request->validate([
            'name_product_cat' => 'sometimes|required|string|max:100',
        ]);

        $category->update($validatedData);
        return response()->json($category);
    }

    /**
     * Remove the specified product category from storage.
     *
     * @param  \App\Models\ProductsCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductsCategory $category)
    {
        $category->delete();
        return response()->json("Category product deleted successfully");
    }
}