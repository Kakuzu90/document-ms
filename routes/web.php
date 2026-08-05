<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = auth()->user()->role;
    $route = $role === 'admin' ? 'admin.dashboard' : 'teacher.dashboard';
    return redirect()->route($route);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/documents', [\App\Http\Controllers\Admin\DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/{document}', [\App\Http\Controllers\Admin\DocumentController::class, 'show'])->name('documents.show');
    Route::post('/documents/{document}/comments', [\App\Http\Controllers\Admin\CommentController::class, 'store'])->name('comments.store');

    Route::resource('teachers', \App\Http\Controllers\Admin\TeacherController::class)->only(['index', 'show', 'edit', 'update']);
});

Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');

    Route::get('/documents', [\App\Http\Controllers\Teacher\DocumentController::class, 'index'])->name('documents.index');
    Route::get('/documents/create', [\App\Http\Controllers\Teacher\DocumentController::class, 'create'])->name('documents.create');
    Route::post('/documents', [\App\Http\Controllers\Teacher\DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}', [\App\Http\Controllers\Teacher\DocumentController::class, 'show'])->name('documents.show');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'read'])->name('notifications.read');
});

require __DIR__.'/auth.php';
