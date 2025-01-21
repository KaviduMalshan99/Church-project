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
use App\Http\Controllers\FilterController;
use App\Http\Controllers\SMSController;


use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Middleware\AdminAuth;


Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');


Route::middleware([App\Http\Middleware\AdminAuth::class])->group(function () {
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
    Route::get('edit/{family_number}', [FamilyController::class, 'edit'])->name('family.edit');
    Route::put('edit/{family_number}', [FamilyController::class, 'update'])->name('family.update'); 
    Route::delete('/{family_number}', [FamilyController::class, 'destroy'])->name('family.destroy');
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
    Route::get('/edit/{id}', [GiftController::class, 'edit'])->name('gift.edit');
    Route::put('/edit/{id}', [GiftController::class, 'update'])->name('gift.update');
    Route::delete('/{id}', [GiftController::class, 'destroy'])->name('gift.destroy');
});


Route::get('/filter', [FilterController::class, 'index'])->name('filter.index');
Route::get('/filter/member-details/{id}', [FilterController::class, 'show'])->name('filter.show');

Route::get('/list', [FilterController::class, 'show_list'])->name('show.list');

// Reports
Route::prefix('reports')->group(function () {
    Route::get('/families', [ReportController::class, 'families'])->name('reports.families');
    Route::get('/members', [ReportController::class, 'members'])->name('reports.members');
    Route::get('/fund_list', [ReportController::class, 'fund_list'])->name('reports.fund_list');
});

// Settings
Route::prefix('settings')->group(function () {
    Route::get('/occupation', [SettingsController::class, 'occupation'])->name('settings.occupation');
    Route::post('/occupation/create', [SettingsController::class, 'occupation_store'])->name('occupation.store');
    Route::delete('/occupation/{id}', [SettingsController::class, 'occupation_destroy'])->name('occupation.destroy');
    Route::put('/occupation/{id}', [SettingsController::class, 'occupation_update'])->name('occupation.update');

    Route::get('/religion', [SettingsController::class, 'religion'])->name('settings.religion');
    Route::post('/religion/create', [SettingsController::class, 'religion_store'])->name('religion.store');
    Route::delete('/religion/{id}', [SettingsController::class, 'religion_destroy'])->name('religion.destroy');
    Route::put('/religion/{id}', [SettingsController::class, 'religion_update'])->name('religion.update');

    Route::get('/held_in_council', [SettingsController::class, 'held_in_council'])->name('settings.held_in_council');
    Route::post('/held_in_council/create', [SettingsController::class, 'held_in_council_store'])->name('held_in_council.store');
    Route::delete('/held_in_council/{id}', [SettingsController::class, 'held_in_council_destroy'])->name('held_in_council.destroy');
    Route::put('/held_in_council/{id}', [SettingsController::class, 'held_in_council_update'])->name('held_in_council.update');

    Route::get('/users', [SettingsController::class, 'users'])->name('settings.users');
    Route::post('/users/create', [SettingsController::class, 'users_store'])->name('users.store');
    Route::delete('/users/{id}', [SettingsController::class, 'users_destroy'])->name('users.destroy');
    Route::put('/users/{id}', [SettingsController::class, 'users_update'])->name('users.update');

    Route::get('/academic_qualifications', [SettingsController::class, 'academic_qualifications'])->name('settings.academic_qualifications');
    Route::post('/academic_qualifications/create', [SettingsController::class, 'academic_qualifications_store'])->name('academic_qualifications.store');
    Route::delete('/academic_qualifications/{id}', [SettingsController::class, 'academic_qualifications_destroy'])->name('academic_qualifications.destroy');
    Route::put('/academic_qualifications/{id}', [SettingsController::class, 'academic_qualifications_update'])->name('academic_qualifications.update');

    Route::get('/contribution_types', [SettingsController::class, 'contribution_types'])->name('settings.contribution_types');
    Route::post('/contribution_types/create', [SettingsController::class, 'contribution_types_store'])->name('contribution_types.store');
    Route::delete('/contribution_types/{id}', [SettingsController::class, 'contribution_types_destroy'])->name('contribution_types.destroy');
    Route::put('/contribution_types/{id}', [SettingsController::class, 'contribution_types_update'])->name('contribution_types.update');
});


});


Route::get('sent-messages', [SMSController::class, 'viewSentMessages'])->name('admin.viewSentMessages');

Route::get('send-sms', [SMSController::class, 'showMainMembers'])->name('admin.send_sms');
Route::post('send-group-sms', [SMSController::class, 'sendGroupSMS'])->name('admin.sendGroupSMS');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
