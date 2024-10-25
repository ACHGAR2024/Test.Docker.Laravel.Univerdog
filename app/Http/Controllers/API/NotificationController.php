<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class NotificationController extends Controller
{
    /**
     * Display a listing of notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = Notification::all();
        return response()->json($notifications);
    }

    /**
     * Store a newly created notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'message' => 'required|string',
            'date_notification' => 'required|date',
            'read' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
        ]);

        $notification = Notification::create($validatedData);
        return response()->json($notification, Response::HTTP_CREATED);
    }

    /**
     * Display the specified notification.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show(Notification $notification)
    {
        return response()->json($notification);
    }

    /**
     * Update the specified notification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Notification $notification)
    {
        $validatedData = $request->validate([
            'message' => 'sometimes|required|string',
            'date_notification' => 'sometimes|required|date',
            'read' => 'sometimes|required|boolean',
            'id_users' => 'sometimes|required|exists:users,id',
        ]);

        $notification->update($validatedData);
        return response()->json($notification);
    }

    /**
     * Remove the specified notification.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json(['message' => 'Notification deleted successfully']);
    }
}