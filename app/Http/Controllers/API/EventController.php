<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    // Method to get all events
    public function index()
    {
        $events = Event::orderBy('created_at', 'desc')->get();
        return response()->json(['events' => $events]);
    }

    // Method to create a new event
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'type_event' => 'nullable|string|max:255',
            'title_event' => 'required|string|max:255',
            'content_event' => 'required|string',
            'event_date' => 'required|date',
            'event_end_date' => 'nullable|date',
            'address_event' => 'required|string|max:255',
            'price_event' => 'required|numeric',
            'photo_event' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'link_event' => 'nullable|string',
            'publication_date' => 'nullable|date',
            'user_id' => 'required|exists:users,id',
        ]);

        // Handle the image upload
        if ($request->hasFile('photo_event')) {
            $image = $request->file('photo_event');
            $name = time() . '_' . $image->getClientOriginalName();
            $filePath = $image->storeAs('images', $name, 'public');
            $validatedData['photo_event'] = '/storage/' . $filePath;
        }

        // Create the event
        $event = Event::create($validatedData);

        return response()->json(['event' => $event, 'message' => 'Event created successfully']);
    }

    // Method to show a specific event
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return response()->json(['event' => $event]);
    }

    // Method to update an event
    public function update(Request $request, $id)
    {
        // Retrieve the event if it exists or return a 404 error if not found
        $event = Event::findOrFail($id);
        $file_temp = $event->photo_event;

        // Validate the request data
        $request->validate([
            'type_event' => 'nullable|string|max:255',
            'title_event' => 'required|string|max:255',
            'content_event' => 'required|string',
            'event_date' => 'required|date',
            'event_end_date' => 'nullable|date',
            'address_event' => 'required|string|max:255',
            'price_event' => 'nullable|numeric',
            'photo_event' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'link_event' => 'nullable|string|max:255',
            'publication_date' => 'nullable|date',
            'user_id' => 'required|exists:users,id',
        ]);

        // Extract the data from the request
        $input = $request->except('photo_event');

        // If a new image is uploaded, handle it and save it
        if ($request->hasFile('photo_event')) {
            // Generate a unique name for the image
            $filenameWithExt = $request->file('photo_event')->getClientOriginalName();
            $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('photo_event')->getClientOriginalExtension();
            $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;
            $path = $request->file('photo_event')->storeAs('images', $filename, 'public');

            // Delete the old image if it exists
            if ($file_temp) {
                Storage::disk('public')->delete('images/' . basename($file_temp));
            }

            // Update the path of the new image in the data to be saved
            $input['photo_event'] = '/storage/' . $path;
        }

        // Update the event with the new data
        $event->update($input);

        // Return a JSON response with the updated event and a success message
        return response()->json(['event' => $event, 'message' => 'Event updated successfully'], 200);
    }

    // Method to delete an event
    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        Storage::disk('public')->delete('images/' . basename($event->photo_event));
        Event::destroy($id);
        return response()->json(['message' => 'Event deleted successfully']);
    }
}