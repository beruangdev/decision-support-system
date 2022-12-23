<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\ProjectMethodController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get("project/list", [ProjectController::class, "list"])->name("project.list");
    Route::get("project/show/list/{project_id}", [ProjectController::class, "show_list"])->name("project.show.list");
    Route::resource("project", ProjectController::class);
    Route::get("alternative/list", [AlternativeController::class, "list"])->name("alternative.list");
    Route::resource("alternative", AlternativeController::class);


    Route::post("project_method/{project_id}", [ProjectMethodController::class, "store"])->name("project_method.store");
    Route::resource("project_method", ProjectMethodController::class)->except([
        'store'
    ]);

});

require __DIR__ . '/auth.php';
