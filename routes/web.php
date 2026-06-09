<?php

use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GuestController;
use App\Http\Controllers\Admin\InvitationContentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Client\DashboardController;
use App\Http\Controllers\Client\GuestController as ClientGuestController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\MonitorController;
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
    if (auth()->user()->isClient()) {
        return redirect()->route('client.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    // User routes
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Event
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [EventController::class, 'create'])->name('events.create');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    // Guest
    Route::get('/event/{event}/guests', [GuestController::class, 'index'])->name('guests.index');
    Route::get('/event/{event}/guests/create', [GuestController::class, 'create'])->name('guests.create');
    Route::post('/event/{event}/guests', [GuestController::class, 'store'])->name('guests.store');
    Route::post('/event/{event}/guests/import', [GuestController::class, 'import'])->name('guests.import');
    Route::delete('/event/{event}/guests/{guest}', [GuestController::class, 'destroy'])->name('guests.destroy');
    Route::get('/event/{event}/guests/{guest}/edit', [GuestController::class, 'edit'])->name('guests.edit');
    Route::put('/event/{event}/guests/{guest}', [GuestController::class, 'update'])->name('guests.update');

    // Invitation
    Route::get('/event/{event}/invitation', [InvitationContentController::class, 'edit'])->name('invitation.edit');
    Route::post('/event/{event}/invitation', [InvitationContentController::class, 'update'])->name('invitation.update');
    Route::delete('/event/{event}/invitation/gallery/{gallery}', [InvitationContentController::class, 'destroyGallery'])->name('invitation.gallery.destroy');
}); 

Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/event/{event}/guests', [ClientGuestController::class, 'index'])->name('guests.index');
    Route::get('/event/{event}/guests/create', [ClientGuestController::class, 'create'])->name('guests.create');
    Route::post('/event/{event}/guests', [ClientGuestController::class, 'store'])->name('guests.store');
    Route::get('/event/{event}/guests/{guest}/edit', [ClientGuestController::class, 'edit'])->name('guests.edit');
    Route::put('/event/{event}/guests/{guest}', [ClientGuestController::class, 'update'])->name('guests.update');
    Route::delete('/event/{event}/guests/{guest}', [ClientGuestController::class, 'destroy'])->name('guests.destroy');
    Route::post('/event/{event}/guests/import', [ClientGuestController::class, 'import'])->name('guests.import');
});

Route::get('/event/{event}/pin', [PinController::class, 'show'])->name('pin.show');
Route::post('/event/{event}/pin', [PinController::class, 'verify'])->name('pin.verify');
Route::middleware('pin.receptionist')->group(function () {
    Route::get('/event/{event}/receptionist', [ReceptionistController::class, 'index'])->name('receptionist.index');
    Route::post('/event/{event}/receptionist/checkin', [ReceptionistController::class, 'checkIn'])->name('receptionist.checkin');
    Route::get('/event/{event}/receptionist/scan/{qr_code}', [ReceptionistController::class, 'scanResult'])->name('receptionist.scan');

});
Route::middleware('pin.souvenir')->group(function () {
    Route::get('/event/{event}/souvenir', [SouvenirController::class, 'index'])->name('souvenir.index');
    Route::post('/event/{event}/souvenir/claim', [SouvenirController::class, 'claim'])->name('souvenir.claim');
});

Route::get('/{slug}/{qr_code}/qr', [InvitationController::class, 'show'])->name('invitation.show');
Route::get('/event/{slug}/monitor', [MonitorController::class, 'show'])->name('monitor.show');