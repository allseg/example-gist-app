<?php

use App\Http\Controllers\GithubGistsCommentsController;
use App\Http\Controllers\GithubGistsController;
use App\Http\Controllers\GithubGistsStarredController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => true,
    ]);
})->name('welcome');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Gists
    Route::get('/gists', [GithubGistsController::class, 'index'])->name('gists.index');
    Route::get('/gists/create', [GithubGistsController::class, 'create'])->name('gists.create');
    Route::get('/gists/show/{gistId}', [GithubGistsController::class, 'show'])->name('gists.show');
    Route::get('/gists/edit/{gistId}', [GithubGistsController::class, 'edit'])->name('gists.edit');
    Route::post('/gists/store', [GithubGistsController::class, 'store'])->name('gists.store');
    Route::patch('/gists/update/{gistId}', [GithubGistsController::class, 'update'])->name('gists.update');
    Route::delete('/gists/delete/{gistId}', [GithubGistsController::class, 'destroy'])->name('gists.delete');

    // Comments
    Route::post('/comments/{gistId}', [GithubGistsCommentsController::class, 'store'])->name('comments.store');
    Route::patch('/comments/{gistId}/{commentId}', [GithubGistsCommentsController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{gistId}/{commentId}', [GithubGistsCommentsController::class, 'destroy'])->name('comments.delete');

    // Starred
    Route::get('/starred', [GithubGistsStarredController::class, 'index'])->name('starred.index');
    Route::put('/starred/{gistId}', [GithubGistsStarredController::class, 'star'])->name('starred.star');
    Route::delete('/starred/{gistId}', [GithubGistsStarredController::class, 'unstar'])->name('starred.unstar');
});

require __DIR__.'/auth.php';


