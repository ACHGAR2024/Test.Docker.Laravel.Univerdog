<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SpecialtyController extends Controller
{
    public function index()
    {
        $specialties = Specialty::all();
        return response()->json($specialties);
    }
    public function index_spe(Request $request)
    {
        $user = auth()->user();
    
        // Fetch specialties where the professional is related to the logged-in user
        $specialties = Specialty::whereHas('professional', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->get();
    
        return response()->json($specialties);
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name_speciality' => 'required|string|max:255',
            'professional_id' => 'required|exists:professionals,id',
        ]);

        $specialty = Specialty::create($validatedData);
        return response()->json($specialty, Response::HTTP_CREATED);
    }

    public function show(Specialty $specialty)
    {
        return response()->json($specialty);
    }

    public function update(Request $request, Specialty $specialty)
    {
        $validatedData = $request->validate([
            'name_speciality' => 'sometimes|required|string|max:255',
            'professional_id' => 'sometimes|required|exists:professionals,id',
        ]);

        $specialty->update($validatedData);
        return response()->json($specialty);
    }

    public function destroy(Specialty $specialty)
    {
        $specialty->delete();
        return response()->json(['message' => 'Specialty deleted successfully']);
    }
}