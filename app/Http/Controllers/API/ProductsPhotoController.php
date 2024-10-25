<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductsPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductsPhotoController extends Controller
{
    /**
     * Display a listing of products photos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productsPhotos = ProductsPhoto::with('product')->get(); // Include relationships if necessary
        return response()->json($productsPhotos);
    }

    /**
     * Store a newly created products photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'photo_name_product' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $file = $request->file('photo_name_product');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('products_photos', $fileName, 'public');

        $productsPhoto = new ProductsPhoto();
        $productsPhoto->product_id = $request->input('product_id');
        $productsPhoto->photo_name_product = $fileName;
        $productsPhoto->save();

        return response()->json($productsPhoto, Response::HTTP_CREATED);
    }

    /**
     * Display the specified products photo.
     *
     * @param  \App\Models\ProductsPhoto  $productsPhoto
     * @return \Illuminate\Http\Response
     */
    public function show(ProductsPhoto $productsPhoto)
    {
        return response()->json($productsPhoto);
    }

    /**
     * Update the specified products photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductsPhoto  $productsPhoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductsPhoto $productsPhoto)
    {
        $request->validate([
            'photo_name_product' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($request->hasFile('photo_name_product')) {
            // Relative path of the old photo
            $oldPhotoPath = 'products_photos/' . $productsPhoto->photo_name_product;
            // Delete the old photo from storage
            if (Storage::disk('public')->exists($oldPhotoPath)) {
                Storage::disk('public')->delete($oldPhotoPath);
            }
            // Store the new photo
            $file = $request->file('photo_name_product');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('products_photos', $fileName, 'public');

            $productsPhoto->photo_name_product = $fileName;
        }

        $productsPhoto->save();
        return response()->json($productsPhoto);
    }

    /**
     * Remove the specified products photo from storage.
     *
     * @param  \App\Models\ProductsPhoto  $productsPhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductsPhoto $productsPhoto)
    {
        // Build the correct path to the image
        $filePath = 'products_photos/' . $productsPhoto->photo_name_product;

        // Delete the photo from storage
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        // Delete the record from the database
        $productsPhoto->delete();

        return response()->json(['message' => 'Photo deleted successfully']);
    }
}