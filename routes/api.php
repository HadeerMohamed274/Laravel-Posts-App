<?php

use App\Http\Controllers\Api\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::get("/hello", function () {

//     return "hello";
// });


Route::apiResource("/posts", PostController::class);



use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json(['message' => 'Invalid Credentials'], 422);
    }
    if($user->tokens()->count() < 3) {
        return $user->createToken($request->device_name)->plainTextToken;
    }
    return response()->json(['message' => 'Maximum accounts reached please logout from one of them'], 422);
});

// Route::post("/sanctum/logout", function () {
//     $user =Auth::user();

//     $user->currentAccessToken()->delete();

//     return response()->json(['message' => 'Logged out successfully'], 200);

// })->middleware('auth:sanctum');


