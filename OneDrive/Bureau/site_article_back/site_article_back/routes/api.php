<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/utilisateurs', [UserController::class, 'index']); // Récupérer tous les utilisateurs
Route::post('/utilisateurs', [UserController::class, 'store']); // Créer un nouvel utilisateur
Route::get('/utilisateurs/{id}', [UserController::class, 'show']); // Récupérer un utilisateur spécifique
Route::put('/utilisateurs/{id}', [UserController::class, 'update']); // Mettre à jour un utilisateur
Route::delete('/utilisateurs/{id}', [UserController::class, 'destroy']); // Supprimer un utilisateur

// Routes pour les articles
Route::get('/articles', [ArticleController::class, 'index']);
Route::post('/articles', [ArticleController::class, 'store']);
Route::get('/articles/{id}', [ArticleController::class, 'show']);
Route::put('/articles/{id}', [ArticleController::class, 'update']);
Route::delete('/articles/{id}', [ArticleController::class, 'destroy']);