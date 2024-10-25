<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB; 
use Google_Client;

use Tymon\JWTAuth\Facades\JWTAuth;

use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\JsonResponse;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Session\Middleware\StartSession;

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Password as PasswordFacade;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;


use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{

    public function loginWithGoogle(Request $request)
    {
        $email = $request->input('email');
        $googleId = $request->input('google_id');
    
        // Find the user by email
        $user = User::where('email', $email)->first();
    
        if (!$user) {
            // The user does not exist, return a 404 error (Not Found)
            return response()->json(['error' => 'Account not found'], 404);
        }
    
        // Check if the user is signing in with Google
        if ($user) {
            Auth::login($user);
            $token = Auth::guard('api')->login($user);
            return response()->json([
                'user' => $user,
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => auth()->factory()->getTTL() * 60
            ]);
        }
        
        // Return an error if the Google authentication fails
        return response()->json(['message' => 'Google authentication failed'], 401);
    }
    
    
    public function redirectToAuth()
    {
        return response()->json([
            'url' => Socialite::driver('google')
                         ->stateless()
                         ->redirect()
                         ->getTargetUrl(),
        ]);
    }
    

public function handleAuthCallback()
{
    try {
        // Retrieve user's information from Google
        $socialiteUser = Socialite::driver('google')
            ->stateless()
            ->setHttpClient(new \GuzzleHttp\Client(['verify' => false]))
            ->user();
    } catch (\Exception $e) {
        return redirect()->route('login')->withErrors(['error' => 'Invalid credentials provided.']);
    }

    // Find or create the user in the database
    $user = User::firstOrCreate(
        ['email' => $socialiteUser->getEmail()],
        [
            'email_verified_at' => now(),
            'name' => $socialiteUser->getName(),
            'google_id' => $socialiteUser->getId(),
            'avatar' => $socialiteUser->getAvatar(),
            'password' => bcrypt(Str::random(16)), // Generate a random password
        ]
    );

    // Authenticate the user
    Auth::login($user);

    // Generate JWT token for the user (if necessary)
    $token = Auth::user()->createToken('Personal Access Token')->accessToken;

    // Redirect the user to the desired URL (https://univerdog.site/login)
    return redirect()->away('https://univerdog.site/login')
                     ->with([
                         'user' => $user,
                         'access_token' => $token,
                         'token_type' => 'Bearer',
                         'expires_in' => 3600 // 1 hour in seconds
                     ]);
}


    


    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return response()->json(['users' => $users]);
    }
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)]
        ));

        return response()->json(['message' => 'User successfully registered', 'user' => $user]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

// app/Http/Controllers/AuthController.php

public function handleGoogleLogin(Request $request)
{
    // Validate incoming data
    $request->validate([
        'tokenId' => 'required|string',
    ]);

    // Initialize the Google client
    $client = new Google_Client(['client_id' => config('services.google.client_id')]);
    $payload = $client->verifyIdToken($request->tokenId);

    if ($payload) {
        // Find or create the user based on the Google profile
        $user = User::firstOrCreate(
            ['email' => $payload['email']],
            ['name' => $payload['name']]
        );

        // Generate and return an access token
        return response()->json([
            'token' => $user->createToken('authToken')->accessToken
        ]);
    } else {
        return response()->json(['error' => 'Invalid token'], 401);
    }
}




    
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'User successfully logged out'])->withHeaders(['Location' => 'https://univerdog.site']);
      
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
        ]);
    }

    public function update(Request $request, User $user)
{
    // Retrieve the authenticated user
    $authenticatedUser = Auth::user();

    // Check that the authenticated user can perform this action
    if ($authenticatedUser->id !== $user->id) {
        return response()->json(['error' => 'Unauthorized'], 403);
    }

    // Temporary save the old image path
    $file_temp = $user->image;

    // Validate the incoming data
    $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,' . $user->id,
        'password' => 'sometimes|string|min:6',
        'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Maximum size of 2MB for images
        'first_name' => 'sometimes|string|max:100|nullable',
        'address' => 'sometimes|string|nullable',
        'postal_code' => 'sometimes|string|max:8|nullable',
        'phone' => 'sometimes|string|max:20|nullable',
    ]);

    // Prepare the data to update, excluding the image
    $input = $request->except('image', 'password');

    // If a new password is provided, hash it and add it to the data to save
    if ($request->filled('password')) {
        $input['password'] = bcrypt($request->password);
    }

    // If a new image is uploaded, process and save it
    if ($request->hasFile('image')) {
        $filenameWithExt = $request->file('image')->getClientOriginalName();
        $filenameWithoutExt = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        $extension = $request->file('image')->getClientOriginalExtension();
        $filename = $filenameWithoutExt . '_' . time() . '.' . $extension;
        $path = $request->file('image')->storeAs('images', $filename, 'public');

        // Delete the old image if it exists
        if ($file_temp) {
            Storage::disk('public')->delete('images/' . basename($file_temp));
        }

        // Update the image path in the data to save
        $input['image'] = '/storage/images/' . $filename;
    }

    // Update the user with the new data
    $user->update($input);

    // Build the URL of the updated image
    if (isset($input['image'])) {
        $imageUrl = asset($input['image']);
        // Add the image URL to the updated user object
        $user->image = $imageUrl;
    }

    // Return a JSON response with the updated user and a success message
    $responseData = [
        'user' => $user,
        'message' => 'User updated successfully'
    ];

    return response()->json($responseData, 200);
}

public function updateAdditionalInfo(Request $request, User $user)
    {
        // Retrieve the authenticated user
        $authenticatedUser = Auth::user();

        // Check that the authenticated user can perform this action
        if ($authenticatedUser->id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Validate the new data received
        $request->validate([
            'first_name' => 'sometimes|string|max:100|nullable',
            'address' => 'sometimes|string|nullable',
            'postal_code' => 'sometimes|string|max:8|nullable',
            'phone' => 'sometimes|string|max:20|nullable',
        ]);

        // Update the additional information of the user
        $input = $request->only('first_name', 'address', 'postal_code', 'phone');
        $user->update($input);

        // Return a JSON response with the updated user and a success message
        return response()->json([
            'user' => $user,
            'message' => 'Additional information updated successfully'
        ], 200);
    }
    public function destroy(User $user)
    {
        $authenticatedUser = Auth::user();
    
        // Check if the authenticated user is an administrator
        if ($authenticatedUser->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }
    
        // Delete the user
        $user->delete();
    
        return response()->json(['message' => 'User deleted successfully']);
    }
    
    // Add this method to your AuthController
    public function updateRole(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Check if the user is authorized to perform this action
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'role' => 'required|string|in:user,professionnel'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user->role = $request->role;
        $user->save();

        return response()->json(['message' => 'Role updated successfully', 'user' => $user]);
    }
 
        
    public function forgotPassword(Request $request, $email)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['message' => 'Email not found.'], 404);
        }

        // Generate a unique token
        $token = Str::random(60);

        // Store the token in the database
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // Here you can send an email to the user with the reset link containing the token. 
        // Exemple : http://votre-domaine.com/reset-password/{token}
        Mail::to($email)->send(new ResetPasswordMail($token, $email));

        return response()->json(['message' => 'Un email de réinitialisation de mot de passe a été envoyé. valable pour 60 minutes.', 'token' => $token], 200);
    }

    
}