<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BooksController;

Route::get('ajax-crud-image-upload', [BooksController::class, 'index'])->name('ajax.dataTable');
Route::post('add-update-book', [BooksController::class, 'store']);
Route::post('edit-book', [BooksController::class, 'edit']);
Route::post('delete-book', [BooksController::class, 'destroy']);

Route::get('book/status/{id}', [BooksController::class, 'status'])->name('book.status');