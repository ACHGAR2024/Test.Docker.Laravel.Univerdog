<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AvailabilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $availabilities = Availability::all();
        return response()->json($availabilities);
    }

 /**
     * Display the availability for a specific professional.
     *
     * @param  int  $professionalId
     * @return \Illuminate\Http\Response
     */
    public function showByProfessional($professionalId)
    {
        $availabilities = Availability::where('professional_id', $professionalId)->get();

        if ($availabilities->isEmpty()) {
            return response()->json(['message' => 'Aucune disponibilité trouvée pour ce professionnel.'], 404);
        }

        return response()->json($availabilities);
    }


/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Availability $availability)
    {
        return response()->json($availability);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'day' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'professional_id' => 'required|exists:professionals,id',
        ]);

        $availability = Availability::create($validatedData);
        return response()->json($availability, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Availability $availability)
    {
        $validatedData = $request->validate([
            'day' => 'sometimes|required|string',
            'start_time' => 'sometimes|required|date_format:H:i',
            'end_time' => 'sometimes|required|date_format:H:i',
            'professional_id' => 'sometimes|required|exists:professionals,id',
        ]);

        $availability->update($validatedData);
        return response()->json($availability);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Availability  $availability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Availability $availability)
    {
        $availability->delete();
        return response()->json("Availability deleted successfully");
    }
}