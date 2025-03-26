<?php

use App\Http\Controllers\Backend\Categoty\CategoryController;
use App\Http\Controllers\Backend\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/',[HomeController::class, 'index'])->name('index');
});



/**CATEGORY */
Route::prefix('admin')->name('category.')->group(function () {
    Route::get('/caregory',[CategoryController::class, 'categoryIndex'])->name('index');
    Route::post('/store',[CategoryController::class, 'categoryStore'])->name('store');
    Route::post('/sub-category-store',[CategoryController::class, 'subCategoryStore'])->name('subcategory.store');
    Route::get('/all-categories',[CategoryController::class, 'allCategories'])->name('all');
});