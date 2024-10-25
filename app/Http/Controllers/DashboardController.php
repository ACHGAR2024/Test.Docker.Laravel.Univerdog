<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Return the information of the authenticated user
        return response()->json([
            'user' => Auth::user(),
        ]);
    }
}