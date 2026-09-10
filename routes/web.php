<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Admin\CatalogController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\BoatOperatorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HotelController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/boat', [BoatOperatorController::class, 'index'])->name('boats.index');
Route::get('/boat/{boat}', [BoatOperatorController::class, 'show'])->name('boats.show');
Route::get('/boat/{boat}/order', [BoatOperatorController::class, 'order'])->name('boats.order');
Route::get('/activity', [ActivityController::class, 'index'])->name('activities.index');
Route::get('/activity/{activity}', [ActivityController::class, 'show'])->name('activities.show');
Route::get('/activity/{activity}/order', [ActivityController::class, 'order'])->name('activities.order');
Route::get('/hotel', [HotelController::class, 'index'])->name('hotels.index');
Route::get('/hotel/{hotel}', [HotelController::class, 'show'])->name('hotels.show');
Route::get('/hotel/{hotel}/order', [HotelController::class, 'order'])->name('hotels.order');
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{article}', [ArticleController::class, 'show'])->name('articles.show');

// Admin console — Figma frames 1:6642 and siblings.
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/boat', [CatalogController::class, 'boats'])->name('boats');
    Route::get('/schedule', [CatalogController::class, 'schedules'])->name('schedules');
    Route::get('/activity', [CatalogController::class, 'activities'])->name('activities');
    Route::get('/hotel', [CatalogController::class, 'hotels'])->name('hotels');
    Route::get('/article', [CatalogController::class, 'articles'])->name('articles');
    Route::get('/report', [CatalogController::class, 'report'])->name('report');

    // "Add new" screens are not built yet; keep the buttons resolvable.
    Route::get('/boat/create', [CatalogController::class, 'createBoat'])->name('boats.create');
    Route::get('/schedule/create', [CatalogController::class, 'createSchedule'])->name('schedules.create');
    Route::get('/activity/create', [CatalogController::class, 'createActivity'])->name('activities.create');
    Route::get('/hotel/create', [CatalogController::class, 'createHotel'])->name('hotels.create');
    Route::get('/article/create', [CatalogController::class, 'createArticle'])->name('articles.create');
});
