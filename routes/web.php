<?php

use App\Http\Controllers\ProfileController;
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

Route::get('welcome', function() {  
    return view('welcome');
});

Route::get('/', function () {
    if (authUser()) {
        if(authUser()->isAdmin()) {
            // return redirect()->route('admin.index');
            return to_route('admin.index');
        }

        if(authUser()->isRegularAdmin()) {
            // return redirect()->route('admin.index');
            return to_route('admin.index');
        }
    }
})->middleware(['auth']);

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';
