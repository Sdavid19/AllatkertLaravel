<?php

use App\Http\Controllers\AnimalController;
use App\Http\Controllers\EnclosureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    //Home
    Route::get('/', [HomeController::class, 'index'])->name('index');


    Route::middleware('admin')->group(function () {
        //Create enclosure
        Route::get('/enclosures/create', [EnclosureController::class, 'create'])->name('enclosures.create');
        Route::post('/enclosures', [EnclosureController::class, 'store'])->name('enclosures.store');

        //Update enclosure
        Route::get('/enclosures/{enclosure}/edit', [EnclosureController::class, 'edit'])->name('enclosures.edit');
        Route::patch('/enclosures/{enclosure}', [EnclosureController::class, 'update'])->name('enclosures.update');

        //Delete enclosure
        Route::delete('/enclosures/{enclosure}', [EnclosureController::class, 'destroy'])->name('enclosures.delete');
    });

    //Ennclosures
    Route::get('/enclosures', [EnclosureController::class, 'index'])->name('enclosures.index');
    Route::get('/enclosures/{enclosure}', [EnclosureController::class, 'show'])->name('enclosures.show');

    //Animals
    Route::middleware('admin')->group(function () {
        //Get archived animals
        Route::get('/animals', [AnimalController::class, 'index'])->name('animals.index');

        //Create animal
        Route::get('/animals/create', [AnimalController::class, 'create'])->name('animals.create');
        Route::post('/animals', [AnimalController::class, 'store'])->name('animals.store');

        //Update animal
        Route::get('/animals/{animal}/edit', [AnimalController::class, 'edit'])->name('animals.edit');
        Route::patch('/animals/{animal}', [AnimalController::class, 'update'])->name('animals.update');

        //Delete naimal
        Route::delete('/animals/{animal}', [AnimalController::class, 'destroy'])->name('animals.delete');

        //Resotre animal
        Route::get('/animals/{animal}/restore', [AnimalController::class, 'showRestoreForm'])->name('animals.restore.form');
        Route::patch('/animals/{animal}/restore', [AnimalController::class, 'restore'])->name('animals.restore');

    });

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
