<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

Auth::routes(['reset' => false, 'verify' => false, 'confirm' => false]);

Route::any('/admin', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('admin');
Route::any('/admin/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('admin.login');
Route::any('/check/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::any('/admin/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('admin.logout');


Route::middleware(['admin'])->prefix('admin')->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('admin.home');

    // staff
    Route::get('/users', [App\Http\Controllers\Admin\UsersController::class, 'index'])->name('admin.users');
    Route::post('/userslist', [App\Http\Controllers\Admin\UsersController::class, 'userslist'])->name('admin.userslist');
    Route::post('/users/save', [App\Http\Controllers\Admin\UsersController::class, 'save'])->name('save.users');
    Route::get('/users/edit', [App\Http\Controllers\Admin\UsersController::class, 'edit'])->name('edit.users');
    Route::post('/users/delete', [App\Http\Controllers\Admin\UsersController::class, 'delete'])->name('delete.users');

    // staff
    Route::get('/course', [App\Http\Controllers\Admin\CourseController::class, 'index'])->name('admin.course');
    Route::post('/courselist', [App\Http\Controllers\Admin\CourseController::class, 'courselist'])->name('admin.courselist');
    Route::post('/course/save', [App\Http\Controllers\Admin\CourseController::class, 'save'])->name('save.course');
    Route::get('/course/edit', [App\Http\Controllers\Admin\CourseController::class, 'edit'])->name('edit.course');
    Route::post('/course/delete', [App\Http\Controllers\Admin\CourseController::class, 'delete'])->name('delete.course');

    //cms
    Route::get('/cms', [App\Http\Controllers\Admin\CmsController::class, 'index'])->name('admin.cms');
    Route::post('/cms/save', [App\Http\Controllers\Admin\CmsController::class, 'save'])->name('admin.cms.save');
    Route::post('/cms/list', [App\Http\Controllers\Admin\CmsController::class, 'list'])->name('admin.cms.list');
    Route::get('/cms/edit/{id}', [App\Http\Controllers\Admin\CmsController::class, 'edit'])->name('admin.cms.edit');
    Route::delete('/cms/delete/{id}', [App\Http\Controllers\Admin\CmsController::class, 'delete'])->name('admin.cms.delete');
    Route::post('/cms/check-slug', [App\Http\Controllers\Admin\CmsController::class, 'check_slug'])->name('admin.cms.check-slug');


    // settings
    Route::get('/settings', [App\Http\Controllers\Admin\SettingsController::class, 'index'])->name('admin.settings');
    Route::post('/settings/save', [App\Http\Controllers\Admin\SettingsController::class, 'save'])->name('save.settings');
    Route::get('/settings/remove_logo', [App\Http\Controllers\Admin\SettingsController::class, 'remove_logo'])->name('remove_logo.settings');
    Route::get('/settings/remove_favicon', [App\Http\Controllers\Admin\SettingsController::class, 'remove_favicon'])->name('remove_favicon.settings');
});
