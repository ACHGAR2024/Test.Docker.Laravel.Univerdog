<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DogsPhoto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DogsPhotoController extends Controller
{
    /**
     * Display a listing of dogs photos.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dogsPhotos = DogsPhoto::with('dog')->get(); // Include relationships if necessary
        return response()->json($dogsPhotos);
    }

    /**
     * Store a newly created dogs photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'dog_id' => 'required|exists:dogs,id',
            'photo_name_dog' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        $file = $request->file('photo_name_dog');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('dogs_photos', $fileName, 'public');

        $dogsPhoto = new DogsPhoto();
        $dogsPhoto->dog_id = $request->input('dog_id');
        $dogsPhoto->photo_name_dog = $fileName;
        $dogsPhoto->save();

        return response()->json($dogsPhoto, Response::HTTP_CREATED);
    }

    /**
     * Display the specified dogs photo.
     *
     * @param  \App\Models\DogsPhoto  $dogsPhoto
     * @return \Illuminate\Http\Response
     */
    public function show(DogsPhoto $dogsPhoto)
    {
        return response()->json($dogsPhoto);
    }

    /**
     * Update the specified dogs photo.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DogsPhoto  $dogsPhoto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DogsPhoto $dogsPhoto)
    {
        $request->validate([
            'photo_name_dog' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        if ($request->hasFile('photo_name_dog')) {
            // Relative path of the old photo
            $oldPhotoPath = 'dogs_photos/' . $dogsPhoto->photo_name_dog;

            // Delete the old photo from storage
            if (Storage::disk('public')->exists($oldPhotoPath)) {
                Storage::disk('public')->delete($oldPhotoPath);
            }

            // Store the new photo
            $file = $request->file('photo_name_dog');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('dogs_photos', $fileName, 'public');

            $dogsPhoto->photo_name_dog = $fileName;
        }

        $dogsPhoto->save();
        return response()->json($dogsPhoto);
    }

    /**
     * Remove the specified dogs photo from storage.
     *
     * @param  \App\Models\DogsPhoto  $dogsPhoto
     * @return \Illuminate\Http\Response
     */
    public function destroy(DogsPhoto $dogsPhoto)
    {
        // Relative path of the photo to delete
        $filePath = 'dogs_photos/' . $dogsPhoto->photo_name_dog;

        // Delete the photo from storage
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }

        $dogsPhoto->delete();

        return response()->json(['message' => 'Photo deleted successfully']);
    }
}