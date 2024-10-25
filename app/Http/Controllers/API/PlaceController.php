<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Place;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Auth;


class PlaceController extends Controller
{
    // Method to get all ads
    public function index()
    {
        $places = Place::orderBy('created_at', 'desc')->get();
        return response()->json(['places' => $places]);
    }

    // Method to create a new ad
    public function store(Request $request)
{
    // Validation of data
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric',
        'user_id' => 'required|exists:users,id',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        'publication_date' => 'nullable|date',
        'address' => 'nullable|string|max:255',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
        'type' => 'nullable|string|max:255',
        'category_ids' => 'nullable|array',
    ]);

    $input = $request->except('photo', 'category_ids');

    // Image upload management
    if ($request->hasFile('photo')) {
        $image = $request->file('photo');
        $name = time() . '_' . $image->getClientOriginalName();
        $filePath = $image->storeAs('images', $name, 'public');
        $input['photo'] = '/storage/' . $filePath;
    }

    DB::beginTransaction();

    try {
        // Ad creation
        $place = Place::create($input);

        // Registration of associated categories
        if ($request->has('category_ids')) {
            $place->categories()->attach($request->input('category_ids'));
        }

        DB::commit();
        return response()->json(['place' => $place, 'message' => 'Place created successfully']);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Failed to create place', 'message' => $e->getMessage()], 500);
    }
}


    // Method to display a specific ad
    public function show($id)
    {
        $place = Place::findOrFail($id);
        return response()->json(['place' => $place]);
    }

    // Method to update an ad
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'user_id' => 'required|exists:users,id',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'publication_date' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'type' => 'nullable|string|max:255',
            'category_ids' => 'nullable|array',
            
        ]);
    
        $place = Place::findOrFail($id);
        $input = $request->except('photo', 'category_ids');
    
        if ($request->hasFile('photo')) {
            $image = $request->file('photo');
            $name = time() . '_' . $image->getClientOriginalName();
            $filePath = $image->storeAs('images', $name, 'public');
            $input['photo'] = '/storage/' . $filePath;
        }
    
        DB::beginTransaction();
    
        try {
            // Ad update
            $place->update($input);
    
            // Registration of associated categories
            if ($request->has('category_ids')) {
                // Delete old associations
                DB::table('ad_categories')->where('place_id', $id)->delete();
                
                $categoryIds = $request->category_ids; // No need to json_decode if already an array
                foreach ($categoryIds as $categoryId) {
                    DB::table('ad_categories')->insert([
                        'place_id' => $place->id,
                        'category_id' => $categoryId,
                    ]);
                }
            }
    
            DB::commit();
            return response()->json(['place' => $place, 'message' => 'Place updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to update place', 'message' => $e->getMessage()], 500);
        }
    }
    
    


    // Method to delete an ad
    public function destroy($id)
    {
        $place = Place::findOrFail($id);

        // Delete associations
        DB::table('ad_categories')->where('place_id', $id)->delete();

        // Delete ad
        $place->delete();

        return response()->json(['message' => 'Place deleted successfully']);
    }

    // Method to get ads by category
    public function getPlacesByCategory($categoryId)
    {
        $places = DB::table('places')
            ->join('ad_categories', 'places.id', '=', 'ad_categories.place_id')
            ->where('ad_categories.category_id', $categoryId)
            ->select('places.*')
            ->orderBy('places.created_at', 'desc')
            ->get();

        return response()->json(['places' => $places]);
    }
}