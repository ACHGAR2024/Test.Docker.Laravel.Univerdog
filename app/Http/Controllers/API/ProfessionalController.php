<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Professional;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ProfessionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $professionals = Professional::all();
        return response()->json($professionals);
    }
    public function index_pro(Request $request)
{
    $user = auth()->user();

    // Fetch professionals where the user_id matches the logged-in user
    $professionals = Professional::where('user_id', $user->id)->get();

    return response()->json($professionals);
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
            'company_name' => 'required|string|max:255',
            'description_pro' => 'required|string',
            'rates' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
            'place_id' => 'required|exists:places,id',
        ]);

        $professional = Professional::create($validatedData);
        return response()->json($professional, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Professional  $professional
     * @return \Illuminate\Http\Response
     */
    public function show(Professional $professional)
    {
        return response()->json($professional);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Professional  $professional
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Professional $professional)
    {
        $validatedData = $request->validate([
            'company_name' => 'sometimes|required|string|max:255',
            'description_pro' => 'sometimes|required|string',
            'rates' => 'nullable|string',
            'user_id' => 'sometimes|required|exists:users,id',
            'place_id' => 'sometimes|required|exists:places,id',
        ]);

        $professional->update($validatedData);
        return response()->json($professional);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Professional  $professional
     * @return \Illuminate\Http\Response
     */
    public function destroy(Professional $professional)
    {
        $professional->delete();
        return response()->json("Company professional deleted successfully");
    }
}