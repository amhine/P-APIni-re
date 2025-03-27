<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\plantescontroller;
use App\Http\Controllers\Api\CommandeController;
use App\Http\Controllers\Api\CategorieController;
use App\Http\Controllers\Api\StatistiquesController;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/', function () {
    return response()->json([
        'message' => "hello"
    ]);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [AuthController::class, 'createUser']);
Route::post('/login', [AuthController::class, 'loginUser']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);


Route::middleware(['auth:api', 'role:client'])->group(function () {
Route::get('/plantes',[plantescontroller::class,'index']);
Route::get('/plantes/{slug}',[plantescontroller::class,'show']);
Route::post('/commandes', [CommandeController::class, 'passerCommande']);
Route::get('/commandes/{id}/etats', [CommandeController::class, 'etatCommande']);
Route::put('/commandes/{id}/annuler', [CommandeController::class, 'annulerCommande']);
});

Route::middleware(['auth:api', 'role:employe'])->group(function () {
    Route::put('/commandes/{id}/preparer', [CommandeController::class, 'comandestatus']);
});


Route::middleware(['auth:api', 'role:admin'])->group(function () {
    Route::get('/categories/afficher', [CategorieController::class, 'index']);
    Route::post('/categories/ajouter', [CategorieController::class, 'store']);
    Route::put('/categories/{id}/update',[CategorieController::class , 'update']);
    Route::delete('/categories/{id}/supprimer',[CategorieController::class , 'destroy']);
    Route::put('/plantes/{id}/modifier',[plantescontroller::class , 'update']);
    Route::delete('/plantes/{id}/supprimer',[plantescontroller::class , 'destroy']);
    Route::get('/statistiques/topplantes', [StatistiquesController::class, 'topPlantes']);
    Route::get('/statistiques/statut', [StatistiquesController::class, 'statistiquesParStatut']);
    Route::post('/plantes/ajouter',[plantescontroller::class , 'store']);

});




   