<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\BlogController;

Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('/gioi-thieu', [BlogController::class, 'introduce'])->name('introduce');
Route::get('/bai-viet/{slug}', [BlogController::class, 'readPost'])->name('read_post');
Route::get('/bai-viet/the-loai/{slug}', [BlogController::class, 'categoryPosts'])->name('category_posts');
Route::get('/bai-viet/tac-gia/{username}', [BlogController::class, 'authorPosts'])->name('author_posts');
Route::get('/bai-viet/tag/{any}', [BlogController::class, 'tagPosts'])->name('tag_posts');
Route::get('/tim-kiem', [BlogController::class, 'searchPosts'])->name('search_posts');
Route::get('/lien-he', [BlogController::class, 'contactPage'])->name('contact');
Route::post('/lien-he', [BlogController::class, 'sendEmail'])->name('send_email')->middleware('throttle:5,1');

//TEST ROUTES
Route::view('/example-page', 'example-page');
Route::view('/example-auth', 'example-auth');


/**
 * ADMIN ROUTES
 */

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest', 'preventBackHistory'])->group(function () {
        Route::controller(AuthController::class)->group(function () {
            Route::get('/login', 'loginForm')->name('login');
            Route::post('/login', 'loginHandler')->name('login_handler');
            Route::get('/forgot-password', 'forgotForm')->name('forgot');
            Route::post('/send-password-reset-link', 'sendPasswordResetLink')->name('send_password_reset_link');
            Route::get('/password/reset/{token}', 'resetForm')->name('reset_password_form');
            Route::post('/reset-password-handler', 'resetPasswordHandler')->name('reset_password_handler');
        });
    });

    Route::middleware(['auth', 'preventBackHistory'])->group(function () {
        Route::controller(AdminController::class)->group(function () {
            Route::get('/dashboard', 'adminDashboard')->name('dashboard');
            Route::post('/logout', 'logoutHandler')->name('logout');
            Route::get('/profile', 'profileView')->name('profile');
            Route::post('/update-profile-picture', 'updateProfilePicture')->name('update_profile_picture');

            Route::middleware(['onlySuperAdmin'])->group(function () {
                Route::get('/settings', 'generalSettings')->name('settings');
                Route::post('/update-logo', 'updateLogo')->name('update_logo');
                Route::post('/update-favicon', 'updateFavicon')->name('update_favicon');
                Route::get('/categories', 'categoriesPage')->name('categories');
                Route::get('/slider', 'manageSlider')->name('slider');
            });
        });

        Route::controller(PostController::class)->group(function () {
            Route::get('/post/new', 'addPost')->name('add_post');
            Route::post('/post/create', 'createPost')->name('create_post');
            Route::get('/posts', 'allPosts')->name('posts');
            Route::get('/post/{id}/edit', 'editPost')->name('edit_post');
            Route::post('/post/update', 'updatePost')->name('update_post');
        });
    });
});
