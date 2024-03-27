<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\FotoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LikedPhotosController;
use App\Http\Controllers\MyPhotoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UploadOrUpdateController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

// Group route yang hanya bisa diakses oleh user terautentifikasi
Route::middleware('auth')->group(function () {
    // Route Get
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('view-detail-photo/{slug}', [FotoController::class, 'view'])->name('view-detail-photo');
    Route::get('my-photo', [MyPhotoController::class, 'index'])->name('my-photo');
    Route::get('create-photo', [UploadOrUpdateController::class, 'create'])->name('create-photo');
    Route::get('edit-photo/{photo}', [UploadOrUpdateController::class, 'edit'])->name('edit-photo');
    Route::get('my-album', [AlbumController::class, 'index'])->name('my-album');
    Route::get('album-details/{album}', [AlbumController::class, 'detail'])->name('album-detail');
    Route::get('private-album', [AlbumController::class, 'private'])->name('private-album');
    Route::get('download-photo/{photo}', [DownloadController::class, 'download'])->name('download-photo');
    Route::get('liked-photos', [LikedPhotosController::class, 'view'])->name('liked-photos');
    Route::get('search-photos', [SearchController::class, 'search'])->name('search-photos');
    Route::get('create-album', [AlbumController::class, 'create'])->name('create-album');
    Route::get('edit-album/{album}', [AlbumController::class, 'edit'])->name('edit-album');
    Route::get('category', [CategoryController::class, 'index'])->name('my-category');
    Route::get('create-category', [CategoryController::class, 'create'])->name('create-category');
    Route::get('update-category/{id}', [CategoryController::class, 'edit'])->name('update-category');

    // Route Post
    Route::post('upload-photo', [FotoController::class, 'upload'])->name('upload-photo');
    Route::post('post-comment/{foto_id}', [KomentarController::class, 'store'])->name('post-comment');
    Route::post('upload-album', [AlbumController::class, 'upload'])->name('upload-album');
    Route::post('like-photo/{photo}', [LikeController::class, 'like'])->name('like-photo');
    Route::post('add-photo-to-album/{photo}', [AlbumController::class, 'addToAlbum'])->name('add-to-album');
    Route::post('category-post', [CategoryController::class, 'post'])->name('category-post');

    // Route Put
    Route::put('update-photo/{photo}', [FotoController::class, 'update'])->name('update-photo');
    Route::put('update-album/{album}', [AlbumController::class, 'update'])->name('update-album');
    Route::put('category-update/{category}', [CategoryController::class, 'update'])->name('category-update');

    // Route Delete
    Route::delete('delete-comment/{comment}', [KomentarController::class, 'deleteComment'])->name('delete-comment');
    Route::delete('delete-photo/{photo}', [FotoController::class, 'delete'])->name('delete-photo');
    Route::delete('delete-album/{album}', [AlbumController::class, 'delete'])->name('delete-album');
    Route::delete('delete-photo-from-album/{photo}/{album}', [AlbumController::class, 'deleteFromAlbum'])->name('delete-from-album');
    Route::delete('category-delete/{category}', [CategoryController::class, 'delete'])->name('category-delete');
    Route::delete('unlike/{id}', [LikeController::class, 'unlike'])->name('unlike');

    // Profile Routes
    Route::controller(ProfileController::class)->group(function () {
        Route::get('profile', 'profilePage')->name('profile.index');
        Route::get('profile-public/{id}', 'profilePublic')->name('profile-public');
        Route::patch('update-photo', 'updatePhotoProfileProcess')->name('profile.update-photo');
        Route::patch('update-password', 'updatePassword')->name('profile.update-password');
        Route::put('update-biodata', 'updateBiodata')->name('profile.update-biodata');
        Route::delete('delete-photo', 'deletePhoto')->name('profile.delete-photo');
    });

    // Keperluan testing
    Route::get('logins/{id}', [KomentarController::class, 'developer']);
});

// Login menggunakan Google
Route::middleware('guest')->controller(AuthController::class)->group(function () {
    Route::get('login/google', 'redirectToGoogle')->name('redirectToGoogle');
    Route::get('login/google/callback', 'handleGoogleCallback')->name('handleGoogleCallback');
});
