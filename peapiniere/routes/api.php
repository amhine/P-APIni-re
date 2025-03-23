<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\plantescontroller;
use App\Http\Controllers\Api\CommandeController;
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
Route::get('/plantes',[plantescontroller::class,'index']);
Route::get('/plantes/{slug}',[plantescontroller::class,'show']);
Route::post('/commander', [CommandeController::class, 'passerCommande']);
Route::get('/commande/{id}', [CommandeController::class, 'etatCommande']);

Route::put('/commande/{id}/annuler', [CommandeController::class, 'annulerCommande']);
Route::middleware(['auth:api', 'role:employe'])->group(function () {
    Route::put('/commandes/{id}/preparer', [CommandeController::class, 'comandestatus']);
});
