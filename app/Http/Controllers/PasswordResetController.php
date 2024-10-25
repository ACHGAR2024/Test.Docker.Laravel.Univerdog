<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Validator; 

class PasswordResetController extends Controller
{
    public function showResetForm($token)
{
    // Check that the token is valid
    $resetToken = DB::table('password_reset_tokens')->where('token', $token)->first();

    if (!$resetToken) {
        return abort(404);
    }

    return view('auth.reset_password', ['token' => $token, 'email' => request()->query('email')]);
}


public function resetPassword(Request $request)
{
    // Validate the form data
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|confirmed|min:6',
        'token' => 'required'
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 422);
    }

    // Check the token
    $passwordReset = DB::table('password_reset_tokens')
                        ->where('email', $request->email)
                        ->where('token', $request->token)
                        ->first();

    if (!$passwordReset) {
        return response()->json(['error' => 'Invalid or expired token'], 400);
    }

    // Get the user
    $user = User::where('email', $request->email)->first();
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }

    // Update the password
    $user->password = bcrypt($request->password);
    $user->save();

    // Delete the password reset token to prevent reuse
    DB::table('password_reset_tokens')->where('email', $request->email)->delete();

    //return response()->json(['message' => 'Password reset successfully.'], 200);
      
// Redirect to the login page with a success message
return redirect('https://univerdog.site/login')->with('status', 'Mot de passe réinitialisé avec succès.');

}


}