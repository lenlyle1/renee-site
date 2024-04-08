<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/setup', function() {
    $credentials = [
        'email' => 'admin@book-me-in.com',
        'password' => 'password'
    ];

    if (!Auth::attempt($credentials)) {
        $user = new \App\Models\User();

        $user->name =  'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);

        $user->save();
        
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $adminToken = $user->createToken('admin-token', [
                'create', 'update', 'delete']);
            $updateToken = $user->createToken('update-token', ['create', 'update']);
            $basicToken = $user->createToken('basic-token', ['none']);

            return [
                'admin' => $adminToken->plainTextToken,
                'update' => $updateToken->plainTextToken,
                'basic' => $basicToken->plainTextToken
            ];
        }
    }
});

/*
    
admin   "1|4BV6lopR2uJhGk0YcLXQlSKpsBjm5MupqYP5e7EA082b8816"
update  "2|yy14ISBsMi8Ty89ZQdUvF5dknoSkHjpya0IBqVE7d7fb2b14"
basic   "3|bNd1lfrWI4dbGQTAFoRKwWUA726vnvhmqrrqDZP970b851f2"

*/