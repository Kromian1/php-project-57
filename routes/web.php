<?php

use App\Http\Controllers\LabelController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusController;
use App\RouteConstants;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('language/{locale}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get(RouteConstants::PROFILE, [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch(RouteConstants::PROFILE, [ProfileController::class, 'update'])->name('profile.update');
    Route::delete(RouteConstants::PROFILE, [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('task_statuses', TaskStatusController::class);

Route::resource('tasks', TaskController::class);

Route::resource('labels', LabelController::class);

require __DIR__ . '/auth.php';
