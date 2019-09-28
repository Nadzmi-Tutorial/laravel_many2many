<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\User;
use App\Role;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/insert', function() {
    $user = User::findOrFail(1);
    $role = new Role(['name' => 'User']);

    $user->roles()->save($role);
});
    
Route::get('/update', function() {
    $user = User::findOrFail(1);

    if($user->has('roles')) {
        foreach($user->roles as $role) {
            if($role->name == 'Administrator') {
                $role->name = 'admin';
                $role->save();
            }
        }
    }
});
    
Route::get('/read', function() {
    $user = User::findOrFail(1);

    foreach($user->roles as $role) {
        echo $role->name;
    }
});
    
Route::get('/delete', function() {
    $user = User::findOrFail(1);

    // $user->roles()->delete(); // delete all rows
    foreach($user->roles as $role) { // delete row
        $role->whereId(3)->delete();
    }
});

// attach role to user
Route::get('/attach', function() {
    $user = User::findOrFail(1);

    $user->roles()->attach(4);
});

// detach a role from user
Route::get('/detach', function() {
    $user = User::findOrFail(1);

    $user->roles()->detach(4);
});

// only attach to the specified role, but detach all other role that's not specified
Route::get('/sync', function() {
    $user = User::findOrFail(1);

    $user->roles()->sync([1]);
});
