<?php

use App\Http\Controllers\Web\S3Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('s3-')->group(function () {
    Route::get('/s3', [S3Controller::class, 'index'])->name('list');
    Route::get('/s3/content', [S3Controller::class, 'openFolder'])->name('open-folder');
    Route::get('/s3/upload', [S3Controller::class, 'uploadFile'])->name('upload-file');
    Route::post('/s3/upload', [S3Controller::class, 'storeFile'])->name('store-file');
    Route::get('/s3/create-folder', [S3Controller::class, 'createFolderForm'])->name('create-folder-form');
    Route::post('/s3/create-folder', [S3Controller::class, 'createFolderHandler'])->name('create-folder');
    Route::delete('/s3/delete-folder', [S3Controller::class, 'deleteFolder'])->name('delete-folder');
    Route::delete('/s3/delete-file', [S3Controller::class, 'deleteFile'])->name('delete-file');
    Route::get('/s3/download-file', [S3Controller::class, 'downloadFile'])->name('download-file');
    Route::get('/s3/rename', [S3Controller::class, 'renameForm'])->name('rename-form');
    Route::post('/s3/rename', [S3Controller::class, 'renameHandler'])->name('rename');
    Route::get('/s3/read-file', [S3Controller::class, 'readFile'])->name('read-file');
});
