<?php

use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;
use App\views\components\layout;

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

// Route::get('/note', [NoteController::class, 'index'])->name('note.index');
// Route::get('/note/create', [NoteController::class, 'create'])->name('note.create');
// Route::post('/note', [NoteController::class, 'store'])->name('note.store');
// Route::get('/note/{id}', [NoteController::class, 'show'])->name('note.show');
// Route::get('/note/{id}/edit', [NoteController::class, 'edit'])->name('note.edit');
// Route::put('/note/{id}', [NoteController::class, 'update'])->name('note.update'); 
// Route::delete('/note/{id}', [NoteController::class, 'destroy'])->name('note.destroy');

Route::resource('note', NoteController::class);

// To DELETE notes
Route::delete('/note/{id}', [NoteController::class, 'destroy'])->name('note.destroy');

// To CREATE new notes
Route::post('/note', [NoteController::class, 'store'])->name('note.store');

// To EDIT NOTES
Route::put('/notes/{note}', [NoteController::class, 'update'])->name('note.update');

Route::get('/note/{id}', [NoteController::class, 'show'])->name('note.show');
