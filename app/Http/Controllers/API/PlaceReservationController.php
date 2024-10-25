<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PlaceReservation;
use App\Models\Event;

class PlaceReservationController extends Controller
{
    // Method to get all reservations
    public function index()
    {
        $places_reservations = PlaceReservation::orderBy('created_at', 'desc')->get();
        return response()->json(['places_reservations' => $places_reservations]);
    }

    // Method to create a new reservation
    public function store(Request $request)
    {
        // Validation of the request data
        $request->validate([
            'name_place_tiket' => 'nullable|string|max:255',
            'address_place' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'reservation_start_date' => 'nullable|date',
            'reservation_end_date' => 'nullable|date',
            'id_events' => 'required|exists:events,id',
        ]);

        // Creation of the reservation
        $reservation = PlaceReservation::create($request->all());

        return response()->json(['reservation' => $reservation, 'message' => 'Reservation created successfully']);
    }

    // Method to display a specific reservation
    public function show($id)
    {
        $reservation = PlaceReservation::findOrFail($id);
        return response()->json(['reservation' => $reservation]);
    }

    // Method to update a reservation
    public function update(Request $request, $id)
    {
        // Get the existing reservation or return a 404 error if not found
        $reservation = PlaceReservation::findOrFail($id);

        // Validation of the request data
        $request->validate([
            'name_place_tiket' => 'nullable|string|max:255',
            'address_place' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:255',
            'reservation_start_date' => 'nullable|date',
            'reservation_end_date' => 'nullable|date',
            'id_events' => 'required|exists:events,id',
        ]);

        // Update the reservation
        $reservation->update($request->all());

        // Return a JSON response with the updated reservation and a success message
        return response()->json(['reservation' => $reservation, 'message' => 'Reservation updated successfully']);
    }

    // Method to delete a reservation
    public function destroy($id)
    {
        $reservation = PlaceReservation::findOrFail($id);
        $reservation->delete();
        return response()->json(['message' => 'Reservation deleted successfully']);
    }
}