<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PlaceController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PhotoController;
use App\Http\Controllers\API\MessageController; 
use App\Http\Controllers\API\EventController; 
use App\Http\Controllers\API\PlaceReservationController; 
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\ReviewController;
use App\Http\Controllers\API\ProfessionalController;
use App\Http\Controllers\API\AvailabilityController;
use App\Http\Controllers\API\SpecialtyController;
use App\Http\Controllers\API\DogController;
use App\Http\Controllers\API\AppointmentController;
use App\Http\Controllers\API\ProductsCategoryController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\DogsPhotoController;
use App\Http\Controllers\API\ProductsPhotoController;
use App\Http\Controllers\API\ContactController;


// Authentication routes
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('/google-login', [AuthController::class, 'handleGoogleLogin']);
Route::middleware('auth:sanctum')->get('/dashboard', [DashboardController::class, 'index']);

Route::get('auth/google', [AuthController::class, 'redirectToAuth']);
Route::get('auth/callback', [AuthController::class, 'handleAuthCallback']);
Route::post('loginGoogle', [AuthController::class, 'loginWithGoogle']);

Route::post('/forgotpw/{email}', [AuthController::class, 'forgotPassword']);
Route::post('/contact', [ContactController::class, 'sendContact']);
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Route to retrieve the currently authenticated user
Route::get('user/{user}', [UserController::class, 'indexprofil']);

// Routes for places (with auth:api middleware to protect routes requiring authentication)
Route::middleware('auth:api')->group(function () {

    Route::post('places', [PlaceController::class, 'store']);
    Route::put('places/{place}', [PlaceController::class, 'update']);
    Route::delete('places/{place}', [PlaceController::class, 'destroy']);

    // New route to manage place photos
    Route::post('places/{place}/photos', [PhotoController::class, 'store']);
    Route::put('places/{place}/photos/{photo}', [PhotoController::class, 'update']);
    Route::delete('places/{place}/photos/{photo}', [PhotoController::class, 'destroy']);
    // destroyAllPhotos : Delete all photos of a place
    Route::delete('places/{place}/photos', [PhotoController::class, 'destroyAllPhotos']);

    


    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{category}', [CategoryController::class, 'update']);   
    Route::delete('categories/{category}', [CategoryController::class, 'destroy']);

    // Routes for messages
    Route::post('messages', [MessageController::class, 'store']);
    Route::post('messages/favorite', [MessageController::class, 'addFavorite']);
    Route::post('messages/report', [MessageController::class, 'report']);
    
    Route::delete('messages/{message}', [MessageController::class, 'destroy']);


    // Routes for events ********************
    Route::post('events', [EventController::class, 'store']);
    Route::put('events/{event}', [EventController::class, 'update']);
    Route::delete('events/{event}', [EventController::class, 'destroy']);

    // Routes for place reservations*********
    Route::post('places_reservations', [PlaceReservationController::class, 'store']);
    Route::put('places_reservations/{reservation}', [PlaceReservationController::class, 'update']);
    Route::delete('places_reservations/{reservation}', [PlaceReservationController::class, 'destroy']);


    Route::get('users', [AuthController::class, 'index']);


    Route::post('logout', [AuthController::class, 'logout']);
    Route::put('update/{user}', [AuthController::class, 'update']);
    Route::delete('users/{user}', [AuthController::class, 'destroy']);
    
    // Route to retrieve the currently authenticated user
    Route::get('user', [UserController::class, 'currentUser']);

    // Route to update user role
    Route::patch('users/{id}/role', [AuthController::class, 'updateRole']);


// Routes for notifications
Route::post('notifications', [NotificationController::class, 'store']);
Route::put('notifications/{notification}', [NotificationController::class, 'update']);
Route::delete('notifications/{notification}', [NotificationController::class, 'destroy']);
 
// Routes for reviews
Route::post('reviews', [ReviewController::class, 'store']);
Route::put('reviews/{review}', [ReviewController::class, 'update']);
Route::delete('reviews/{review}', [ReviewController::class, 'destroy']);

// Routes for professionals
Route::post('professionals', [ProfessionalController::class, 'store']);
Route::put('professionals/{professional}', [ProfessionalController::class, 'update']);
Route::delete('professionals/{professional}', [ProfessionalController::class, 'destroy']);


// Routes for availability
Route::post('availability', [AvailabilityController::class, 'store']);
Route::put('availability/{availability}', [AvailabilityController::class, 'update']);
Route::delete('availability/{availability}', [AvailabilityController::class, 'destroy']);

// Routes for specialties
Route::post('speciality', [SpecialtyController::class, 'store']);
Route::put('speciality/{specialty}', [SpecialtyController::class, 'update']);
Route::delete('speciality/{specialty}', [SpecialtyController::class, 'destroy']);

// Routes for dogs
Route::post('dogs', [DogController::class, 'store']);
Route::put('dogs/{dog}', [DogController::class, 'update']);
Route::delete('dogs/{dog}', [DogController::class, 'destroy']);

// Routes for appointments
Route::post('appointments', [AppointmentController::class, 'store']);
Route::put('appointments/{appointment}', [AppointmentController::class, 'update']);
Route::delete('appointments/{appointment}', [AppointmentController::class, 'destroy']);

// Routes for products categories
Route::post('products-categories', [ProductsCategoryController::class, 'store']);
Route::put('products-categories/{category}', [ProductsCategoryController::class, 'update']);
Route::delete('products-categories/{category}', [ProductsCategoryController::class, 'destroy']);

// Routes for products
Route::post('products', [ProductController::class, 'store']);
Route::put('products/{product}', [ProductController::class, 'update']);
Route::delete('products/{product}', [ProductController::class, 'destroy']);

// Routes for dogs photos
Route::post('dogs-photos', [DogsPhotoController::class, 'store']);
Route::put('dogs-photos/{dogsPhoto}', [DogsPhotoController::class, 'update']);
Route::delete('dogs-photos/{dogsPhoto}', [DogsPhotoController::class, 'destroy']);


// Routes for products photos
Route::post('products-photos', [ProductsPhotoController::class, 'store']);
Route::put('products-photos/{productsPhoto}', [ProductsPhotoController::class, 'update']);
Route::delete('products-photos/{productsPhoto}', [ProductsPhotoController::class, 'destroy']);




    //End of routes with middleware
    
});


    
// Routes for places accessible publicly
Route::get('places', [PlaceController::class, 'index']);
Route::get('places/{place}', [PlaceController::class, 'show']);
Route::get('places/category/{categoryId}', [PlaceController::class, 'getPlacesByCategory']);

Route::get('messages', [MessageController::class, 'index']);

// Routes for photos accessible publicly
Route::get('places/{place}/photos', [PhotoController::class, 'index']);
Route::get('places/{place}/photos/{photo}', [PhotoController::class, 'show']);

// Routes for categories accessible publicly
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);


// Routes for events accessible publicly*****************
Route::get('events', [EventController::class, 'index']);
Route::get('events/{event}', [EventController::class, 'show']);

// Routes for reservations accessible publicly***************
Route::get('places_reservations', [PlaceReservationController::class, 'index']);
Route::get('places_reservations/{reservation}', [PlaceReservationController::class, 'show']);


// Routes for notifications accessible publicly
Route::get('notifications', [NotificationController::class, 'index']);
Route::get('notifications/{notification}', [NotificationController::class, 'show']);


// Routes for reviews accessible publicly
Route::get('reviews', [ReviewController::class, 'index']);
Route::get('reviews/{review}', [ReviewController::class, 'show']);

// Routes for professionals accessible publicly
Route::get('professionals', [ProfessionalController::class, 'index']);
Route::get('professionals_pro', [ProfessionalController::class, 'index_pro']);
Route::get('professionals/{professional}', [ProfessionalController::class, 'show']);

// Routes for availability accessible publicly
Route::get('availability', [AvailabilityController::class, 'index']);
Route::get('availability/{availability}', [AvailabilityController::class, 'show']);
Route::get('availability_pro/{professional_id}', [availabilityController::class, 'showByProfessional']);

// Routes for specialties accessible publicly
Route::get('speciality', [SpecialtyController::class, 'index']);
Route::get('speciality_spe', [SpecialtyController::class, 'index_spe']);
Route::get('speciality/{specialty}', [SpecialtyController::class, 'show']);

// Routes for dogs accessible publicly
Route::get('dogs', [DogController::class, 'index']);
Route::get('dogs/{dog}', [DogController::class, 'show']);
Route::get('dogs_user/{user_id}', [DogController::class, 'dogShowUser']);

// Routes for appointments accessible publicly
Route::get('appointments', [AppointmentController::class, 'index']);
Route::get('appointments/{appointment}', [AppointmentController::class, 'show']);
Route::get('appointments_pro/{professional_id}', [AppointmentController::class, 'showByProfessional']);
Route::get('appointments_pro/{professional_id}/{dog_id}', [AppointmentController::class, 'showByProAndDog']);

// Routes for products categories accessible publicly
Route::get('products-categories', [ProductsCategoryController::class, 'index']);
Route::get('products-categories/{category}', [ProductsCategoryController::class, 'show']);

// Routes for products accessible publicly
Route::get('products', [ProductController::class, 'index']);
Route::get('products/{product}', [ProductController::class, 'show']);

// Routes for dogs photos accessible publicly
Route::get('dogs-photos', [DogsPhotoController::class, 'index']);
Route::get('dogs-photos/{dogsPhoto}', [DogsPhotoController::class, 'show']);

// Routes for products photos accessible publicly
Route::get('products-photos', [ProductsPhotoController::class, 'index']);
Route::get('products-photos/{productsPhoto}', [ProductsPhotoController::class, 'show']);





// Routes protected by auth:api and admin role
Route::middleware(['auth:api', 'role:admin'])->group(function () {
    // Specific routes for admins here
    
    
}); 