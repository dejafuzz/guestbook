<?php

use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PinController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\SouvenirController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

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
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    // Event
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // Guest
    Route::get('/event/{event}/guests', [GuestController::class, 'index'])->name('guests.index');
    Route::post('/event/{event}/guests/import', [GuestController::class, 'import'])->name('guests.import');
    Route::delete('/event/{event}/guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');
}); 


Route::get('/event/{event}/pin', [PinController::class, 'show'])->name('pin.show');
Route::post('/event/{event}/pin', [PinController::class, 'verify'])->name('pin.verify');


Route::middleware('pin.receptionist')->group(function () {
    Route::get('/event/{event}/receptionist', [ReceptionistController::class, 'index'])->name('receptionist.index');
    Route::post('/event/{event}/receptionist/checkin', [ReceptionistController::class, 'checkIn'])->name('receptionist.checkin');
});

Route::middleware('pin.souvenir')->group(function () {
    Route::get('/event/{event}/souvenir', [SouvenirController::class, 'index'])->name('souvenir.index');
    Route::post('/event/{event}/souvenir/claim', [SouvenirController::class, 'claim'])->name('souvenir.claim');
});

Route::get('/{slug}/{qr_code}/qr', [InvitationController::class, 'show'])->name('invitation.show');