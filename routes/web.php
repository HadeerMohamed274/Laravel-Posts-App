<?php

use App\Http\Controllers\postController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  return view('welcome');
});

Route::get("posts/trash", [postController::class, "showDeletedPosts"])
  ->name("posts.trash");

Route::get("posts/trash", [postController::class, "trash"])->name("posts.trash");

Route::post("posts/restore-all", [postController::class, "restoreAll"])
  ->name("posts.restoreAll");

Route::post("posts/{id}/restore", [postController::class, "restore"])
  ->name("posts.restore")->where("id", "[0-9]+");

Route::delete("posts/{id}/hard-destroy", [postController::class, "hardDestroy"])
  ->name("posts.hardDestroy")->where("id", "[0-9]+");

Route::get('/posts/{post}/comment-form', [postController::class, 'commentForm'])
  ->name('posts.comment.form');

Route::post('/posts/{post}/comment', [postController::class, 'addComment'])
  ->name('posts.comment');

Route::middleware(['auth'])->group(function () {
  Route::resource('posts', postController::class);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use Laravel\Socialite\Facades\Socialite;
 
Route::get('/auth/redirect', function () {
  // return 'github';
    return Socialite::driver('github')->redirect();
})->name('github.login');
 
Route::get('/auth/callback', function () {
  $githubUser = Socialite::driver('github')->user();
 
    $user = User::updateOrCreate([
        'github_id' => $githubUser->id,
    ], [
        'name' => $githubUser->name,
        'email' => $githubUser->email,
        'password' => Hash::make($githubUser->token),
        'image' => $githubUser->getAvatar(),
        'github_token' => $githubUser->token,
        'github_refresh_token' => $githubUser->refreshToken,
    ]);
 
    Auth::login($user);
 
    return redirect('/');
});


// Route::get('/auth/redirect', function () {
//     return Socialite::driver('google')->redirect();
// })->name('google.login');


// Route::get('/auth/callback', function () {
//     $user = Socialite::driver('google')->user();

//     $user = User::updateOrCreate([
//         'google_id' => $user->id,
//     ], [
//         'name' => $user->name,
//         'email' => $user->email,
//         'password' => Hash::make($user->token),
//         'image' => $user->getAvatar(),
//         'google_token' => $user->token,
//         'google_refresh_token' => $user->refreshToken,
//     ]);
// });