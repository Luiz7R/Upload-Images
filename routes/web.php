<?php

use App\Http\Controllers\ImagesController;
use App\Http\Controllers\UploadImageController;
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

Route::get('/', [ImagesController::class, 'getImages']);

Route::post('/postImage', [UploadImageController::class, 'addImage'])->name('upImage');
Route::post('/deleteImage/{id}', [UploadImageController::class, 'delImg'])->name('delImg');
