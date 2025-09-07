<?php

use Illuminate\Support\Facades\Route;

// Аутентификация
Route::view('/admin/login', 'admin.auth.login')->name('admin.login');
Route::view('/admin/register', 'admin.auth.register')->name('admin.register');

// Главная админки → редиректы (в реальных проекатах так не делаю :)
Route::redirect('/', '/admin/events')->name('admin.home');
Route::redirect('/admin', '/admin/events')->name('admin.home');

// События
Route::prefix('admin/events')->group(function () {
    Route::view('/', 'admin.events.index')->name('admin.events.index');
    Route::view('/{id}', 'admin.events.show')->name('admin.events.show');
});

// Пользователи
Route::prefix('admin/users')->group(function () {
    Route::view('/', 'admin.users.index')->name('admin.users.index');
    Route::view('/{id}', 'admin.users.show')->name('admin.users.show');
});

// Logout (очистка и редирект на логин)
Route::get('/admin/logout', function () {
    return view('admin.auth.logout');
})->name('admin.logout');
