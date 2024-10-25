<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class MessageController extends Controller
{
    // Display a listing of messages.
    public function index()
    {
        $messages = Message::orderBy('created_at', 'desc')->get();
        return response()->json($messages);
    }

     // Existing method to store a message
     public function store(Request $request)
     {
         $request->validate([
             'place_id' => 'required|integer',
             'content' => 'required|string',
             'status' => 'nullable|string|max:50', // Make sure the status is valid
         ]);
     
         try {
            $message = Message::create([
                'user_id' => auth()->id(), // Use the authenticated user
                'place_id' => $request->place_id,
                'content' => $request->content,
                'status' => isset($request->status) ? $request->status : 'En attente', // Default value
            ]);
            
     
             return response()->json($message, 201);
         } catch (\Exception $e) {
             \Log::error('Error when adding message: ' . $e->getMessage());
             return response()->json(['message' => 'Server error'], 500);
         }
     }
     
     public function addFavorite(Request $request)
{
    $request->validate([
        'place_id' => 'required|integer|exists:places,id',
        'content' => 'nullable|string',
        'status' => 'nullable|string|max:50'
    ]);

    try {
        $userId = Auth::id(); // Use Auth to get the user ID

        $message = Message::where('place_id', $request->place_id)
                          ->where('user_id', $userId)
                          ->first();

        if (!$message) {
            $message = Message::create([
                'user_id' => $userId,
                'place_id' => $request->place_id,
                'content' =>  ($request->content) ? $request->content : 'Favoris Ajouté',
                'status' => ($request->status) ? $request->status : 'Favoris Ajouté',
                'is_favorite' => true,
            ]);
        } else {
            $message->is_favorite = true;
            $message->content = ($request->content) ? $request->content : $message->content;
            $message->status = ($request->status) ? $request->status : $message->status;
            $message->save();
        }

        return response()->json(['message' => 'Message ajouté aux favoris'], 200);
    } catch (\Exception $e) {
        \Log::error('Erreur lors de l\'ajout aux favoris: ' . $e->getMessage());
        return response()->json(['message' => 'Erreur serveur'], 500);
    }
}

     
     // New method to report
     public function report(Request $request)
    {
        $request->validate([
            'place_id' => 'required|integer|exists:places,id',
            'content' => 'nullable|string',
            'status' => 'nullable|string|max:50'
        ]);

        try {
            $userId = Auth::id(); // Use Auth to get the user ID

            $message = Message::where('place_id', $request->place_id)
                              ->where('user_id', $userId)
                              ->first();

            if (!$message) {
                $message = Message::create([
                    'user_id' => $userId,
                    'place_id' => $request->place_id,
                    'content' => ($request->content) ? $request->content : 'Signalement Ajouté',
                    'status' => ($request->status) ? $request->status : 'Signalement Ajouté',
                    'is_report' => true,
                ]);
            } else {
                $message->is_report = true;
                $message->content = ($request->content) ? $request->content : $message->content;
                $message->status = ($request->status) ? $request->status : $message->status;
                $message->save();
            }

            return response()->json(['message' => 'Annonce signalée'], 200);
        } catch (\Exception $e) {
            \Log::error('Erreur lors du signalement: ' . $e->getMessage());
            return response()->json(['message' => 'Erreur serveur'], 500);
        }
    }


    // Display the specified message.
    public function show($id)
    {
        $message = Message::findOrFail($id);
        return response()->json($message);
    }

    // Update the specified message in storage.
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'exists:users,id',
            'place_id' => 'exists:places,id',
            'content' => 'string',
            'status' => 'string|max:50',
            'is_favorite' => 'boolean',
            'is_report' => 'boolean',
        ]);

        $message = Message::findOrFail($id);
        $message->update($request->all());
        return response()->json("Message mis à jour avec succès", 200);
    }

    // Remove the specified message from storage.
    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        return response()->json('Message supprimé avec succès', 200);
    }
}