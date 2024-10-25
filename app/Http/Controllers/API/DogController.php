<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dogs = Dog::all();
        return response()->json($dogs);
    }
public function dogShowUser($id)
{
    $dogs = Dog::where('user_id', $id)->get();
    return response()->json($dogs);
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
            'name_dog' => 'required|string|max:100',
            'breed' => 'required|string|max:100',
            'birth_date' => 'required|date',
            'weight' => 'required|numeric',
            'sex' => 'required|string|max:10',
            'medical_info' => 'nullable|string',
            'qr_code' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $dog = Dog::create($validatedData);
        return response()->json($dog, Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Dog  $dog
     * @return \Illuminate\Http\Response
     */
    public function show(Dog $dog)
    {
        return response()->json($dog);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Dog  $dog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dog $dog)
    {
        $validatedData = $request->validate([
            'name_dog' => 'sometimes|required|string|max:100',
            'breed' => 'sometimes|required|string|max:100',
            'birth_date' => 'sometimes|required|date',
            'weight' => 'sometimes|required|numeric',
            'sex' => 'sometimes|required|string|max:10',
            'medical_info' => 'nullable|string',
            'qr_code' => 'nullable|string',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        $dog->update($validatedData);
        return response()->json($dog);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Dog  $dog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dog $dog)
    {
        $dog->delete();
        return response()->json("Card dog deleted successfully");
    }
}