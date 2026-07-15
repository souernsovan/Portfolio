<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\MessageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\SkillCategoryController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/projects/{project:slug}', [ProjectController::class, 'show'])->name('projects.show');
Route::post('/contact', [PublicContactController::class, 'store'])->name('contact.store');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AdminAuthController::class, 'login'])->name('login.attempt');

    Route::middleware('admin.auth')->group(function () {
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('projects', AdminProjectController::class)->except(['show']);
        Route::resource('skills', SkillController::class)->except(['show']);
        Route::post('skill-categories', [SkillCategoryController::class, 'store'])->name('skill-categories.store');
        Route::put('skill-categories/{skillCategory}', [SkillCategoryController::class, 'update'])->name('skill-categories.update');
        Route::delete('skill-categories/{skillCategory}', [SkillCategoryController::class, 'destroy'])->name('skill-categories.destroy');
        Route::get('skill-categories', [SkillCategoryController::class, 'index'])->name('skill-categories.index');
        Route::resource('experiences', ExperienceController::class)->except(['show']);
        Route::resource('testimonials', TestimonialController::class)->except(['show']);

        Route::get('messages', [MessageController::class, 'index'])->name('messages.index');
        Route::get('messages/{message}', [MessageController::class, 'show'])->name('messages.show');
        Route::post('messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');
        Route::delete('messages/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    });
});
