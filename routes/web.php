<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\AlternativeController;
use App\Http\Controllers\CalculateController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\ProjectMethodController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Vite;
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


    Route::prefix('project')->group(function () {
        // Calculate
        Route::post("{project}/method/{project_method}/calculate/{calculate_id}/alternative/list", [CalculateController::class, "alternative_list"])->name("calculate.alternative.list");
        Route::resource("{project}/method/{project_method}/calculate", CalculateController::class)->names("calculate");

        // Criteria
        Route::put("{project}/method/{project_method}/update_weight", [CriteriaController::class, "update_weight"])->name("criteria.update_weight");

        // Project Method
        Route::get("{project}/method/list", [ProjectMethodController::class, "list"])->name("project_method.list");
        Route::get("method/get_default", [ProjectMethodController::class, "get_default"])->name("project_method.get_default");
        Route::post("{project}/method", [ProjectMethodController::class, "store"])->name("project_method.store");
        Route::resource("{project}/method", ProjectMethodController::class)->names("project_method")->except([
            'store'
        ]);


        // Alternative
        Route::get("{project}/alternative/upload", [AlternativeController::class, "upload"])->name("alternative.upload");
        Route::get("{project}/alternative/list", [AlternativeController::class, "list"])->name("alternative.list");
        Route::resource("{project}/alternative", AlternativeController::class);
    });

    // Project
    Route::as('project.')->prefix("project")->group(function () {
        Route::get("show/list/{project}", [ProjectController::class, "show_list"])->name("show.list");
        Route::get("list", [ProjectController::class, "list"])->name("list");

        // Project Attribute
        Route::get("{project}/attribute", [ProjectController::class, "attribute"])->name("attribute");
        Route::post("{project}/attribute", [ProjectController::class, "attribute_update"])->name("attribute");
    });
    Route::resource("project", ProjectController::class);
});

require __DIR__ . '/auth.php';
