<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Fundraiser;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\Member;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

// Tautan undangan (publik: bisa dibuka tanpa login)
Route::get('/undangan/{token}', [InvitationController::class, 'show'])->name('invitations.show');

Route::middleware('auth')->group(function () {
    Route::post('/undangan/{token}/gabung', [InvitationController::class, 'join'])->name('invitations.join');

    // Breeze mengarahkan setelah login ke route 'dashboard'; di sini diteruskan per peran
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/segera/{page}', [PageController::class, 'soon'])->name('placeholder');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:super_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::get('/pengguna', [Admin\UserController::class, 'index'])->name('users');
        Route::patch('/pengguna/{user}/status', [Admin\UserController::class, 'toggle'])->name('users.toggle');
        Route::get('/grup', [Admin\GroupController::class, 'index'])->name('groups');
        Route::patch('/grup/{group}/status', [Admin\GroupController::class, 'toggle'])->name('groups.toggle');
    });

    Route::middleware('role:fundraiser')->prefix('penggalang')->name('fundraiser.')->group(function () {
        Route::get('/', [Fundraiser\DashboardController::class, 'index'])->name('dashboard');
        Route::get('anggota', [Fundraiser\MemberController::class, 'index'])->name('members.index');
        Route::patch('anggota/{member}/keluarkan', [Fundraiser\MemberController::class, 'remove'])->name('members.remove');
        Route::patch('anggota/{member}/pulihkan', [Fundraiser\MemberController::class, 'restore'])->name('members.restore');

        // CRUD Grup -> fundraiser.groups.index|create|store|show|edit|update|destroy
        Route::resource('grup', Fundraiser\GroupController::class)
            ->parameters(['grup' => 'group'])
            ->names('groups');

        // Tautan undangan per grup
        Route::post('grup/{group}/undangan', [Fundraiser\InvitationController::class, 'store'])
            ->name('groups.invitations.store');
        Route::patch('grup/{group}/undangan/{invitation}', [Fundraiser\InvitationController::class, 'deactivate'])
            ->name('groups.invitations.deactivate');
    });

    Route::middleware('role:member')->prefix('anggota')->name('member.')->group(function () {
        Route::get('/', [Member\DashboardController::class, 'index'])->name('dashboard');
    });
});

require __DIR__.'/auth.php';