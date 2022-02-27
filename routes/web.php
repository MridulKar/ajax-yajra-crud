<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;

Route::get('ajax-crud-image-upload', [BooksController::class, 'index'])->name('ajax.datatable');
Route::post('add-update-book', [BooksController::class, 'store']);
Route::post('edit-book', [BooksController::class, 'edit']);
Route::post('delete-book', [BooksController::class, 'destroy']);
