<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
//use App\Models\Professional;

class AppointmentController extends Controller
{
    /**
     * Afficher une liste des rendez-vous.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }

/**
     * Afficher une liste des rendez-vous pour un professionnel spécifique.
     *
     * @param  int  $professional_id
     * @return \Illuminate\Http\Response
     */
    public function showByProfessional($professional_id)
    {
        // Valider le professional_id
        $appointments = Appointment::where('professional_id', $professional_id)
            ->orderByDesc('created_at')
            ->get();

        if ($appointments->isEmpty()) {
            return response()->json(['message' => 'No appointments found for this professional.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($appointments);
    }
    


    
    /**
     * Afficher une liste des rendez-vous pour un chien spécifique.avec un professionnel
     *
     * @param  int  $dog_id
     * @return \Illuminate\Http\Response
     */
    public function showByProAndDog($professional_id, $dog_id)
    {
        // Valider le dog_id
        // Rechercher les rendez-vous qui ont lieu avec le professionnel $professional_id
        // et qui concernent le chien $dog_id
        $appointments = Appointment::where('dog_id', $dog_id)
                                ->where('professional_id', $professional_id)
                                ->get();

        if ($appointments->isEmpty()) {
            return response()->json(['message' => 'No appointments found for this dog.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($appointments);
    }
    
    /**
     * Stocker un nouveau rendez-vous.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'date_appointment' => 'required|date',
            'time_appointment' => 'required|date_format:H:i',
            'reason' => 'sometimes|string|nullable',
            'status' => 'required|string|max:255',
            'dog_id' => 'required|exists:dogs,id',
            'professional_id' => 'required|exists:professionals,id',
        ]);

        $appointment = Appointment::create($validatedData);
        return response()->json($appointment, Response::HTTP_CREATED);
    }

    /**
     * Afficher un rendez-vous spécifique.
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        return response()->json($appointment);
    }

    /**
     * Mettre à jour un rendez-vous spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $validatedData = $request->validate([
            'date_appointment' => 'sometimes|required|date',
            'time_appointment' => 'sometimes|required|date_format:H:i',
            'reason' => 'sometimes|string|nullable',
            'status' => 'sometimes|required|string|max:255',
            'dog_id' => 'sometimes|required|exists:dogs,id',
            'professional_id' => 'sometimes|required|exists:professionals,id',
        ]);

        $appointment->update($validatedData);
        return response()->json($appointment);
    }

    /**
     * Supprimer un rendez-vous spécifique..
     *
     * @param  \App\Models\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return response()->json(['message' => 'Appointment deleted successfully']);
    }
}