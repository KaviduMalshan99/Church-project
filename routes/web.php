<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChurchController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingsController;


//frontend pages
Route::get('/', [HomeController::class, 'index'])->name('dashboard');

// Church Management
Route::prefix('church')->group(function () {
    Route::get('/main', [ChurchController::class, 'main'])->name('church.main');
    Route::get('/main/create', [ChurchController::class, 'create'])->name('church.main.create');
    Route::post('/main', [ChurchController::class, 'store'])->name('church.main.store');
    Route::get('/main/{id}/edit', [ChurchController::class, 'edit'])->name('church.main.edit');
    Route::put('/main/{id}', [ChurchController::class, 'update'])->name('church.main.update');
    Route::delete('/main/{id}', [ChurchController::class, 'destroy'])->name('church.main.delete');

    // Sub-church Routes
    Route::get('/sub', [ChurchController::class, 'sub'])->name('church.sub'); // List of sub-churches
    Route::get('/sub/create', [ChurchController::class, 'createSub'])->name('church.sub.create'); // Form to create a sub-church
    Route::post('/sub', [ChurchController::class, 'storeSub'])->name('church.sub.store'); // Store new sub-church
    Route::get('/sub/{id}/edit', [ChurchController::class, 'editSub'])->name('church.sub.edit'); // Edit sub-church
    Route::put('/sub/{id}', [ChurchController::class, 'updateSub'])->name('church.sub.update'); // Update sub-church
    Route::delete('/sub/{id}', [ChurchController::class, 'destroySub'])->name('church.sub.delete'); // Delete sub-church
});



// Family Management
Route::prefix('family')->group(function () {
    Route::get('/list', [FamilyController::class, 'index'])->name('family.list');
    Route::get('/create', [FamilyController::class, 'create'])->name('family.create');
    Route::post('/store', [FamilyController::class, 'store'])->name('family.store');
    Route::get('/{id}', [FamilyController::class, 'show'])->name('family.show');
    Route::get('edit/{id}', [FamilyController::class, 'edit'])->name('family.edit');
    Route::put('edit/{id}', [FamilyController::class, 'update'])->name('family.update');
    Route::delete('/{id}', [FamilyController::class, 'destroy'])->name('family.destroy');
});

// Member Management
Route::prefix('member')->group(function () {
    Route::get('/list', [MemberController::class, 'index'])->name('member.list');
    Route::get('/create', [MemberController::class, 'create'])->name('member.create');
    Route::post('/store', [MemberController::class, 'store'])->name('member.store');
    Route::get('/{id}', [MemberController::class, 'show'])->name('member.show');
    Route::get('edit/{id}', [MemberController::class, 'edit'])->name('member.edit');
    Route::put('edit/{id}', [MemberController::class, 'update'])->name('member.update');
    Route::delete('/{id}', [MemberController::class, 'destroy'])->name('member.destroy');
});


// Gift Management
Route::prefix('gift')->group(function () {
    Route::get('/list', [GiftController::class, 'index'])->name('gift.list');
    Route::get('/create', [GiftController::class, 'create'])->name('gift.create');
    Route::post('/create', [GiftController::class, 'store'])->name('gift.store');
    Route::get('edit/{id}', [GiftController::class, 'edit'])->name('gift.edit');
    Route::put('edit/{id}', [GiftController::class, 'update'])->name('gift.update');
    Route::delete('/{id}', [GiftController::class, 'destroy'])->name('gift.destroy');
});

// Reports
Route::prefix('reports')->group(function () {
    Route::get('/customers', [ReportController::class, 'customers'])->name('reports.customers');
    Route::get('/products', [ReportController::class, 'products'])->name('reports.products');
    Route::get('/affiliate', [ReportController::class, 'affiliate'])->name('reports.affiliate');
    Route::get('/bank', [ReportController::class, 'bank'])->name('reports.bank');
    Route::get('/vendors', [ReportController::class, 'vendors'])->name('reports.vendors');
});

// Settings
Route::prefix('settings')->group(function () {
    Route::get('/company', [SettingsController::class, 'company'])->name('settings.company');
    Route::get('/users', [SettingsController::class, 'users'])->name('settings.users');
    Route::get('/roles', [SettingsController::class, 'roles'])->name('settings.roles');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
