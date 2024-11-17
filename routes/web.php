<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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
    return view('welcome');
});

Route::group(['prefix' => ''], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
    Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
    Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
});

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'loginPost'])->name('admin.login.post');
Route::group(['prefix' => 'admin', ' middleware' => 'auth'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');

    Route::resource('category', CategoryController::class);


    Route::resource('book', BookController::class);

    Route::resource('contact', ContactController::class);

    Route::resource('user', UserController::class);

    Route::resource('blog', BlogController::class);
});

Route::post('/upload-image', function (Request $request) {
    $image = $request->file('upload');
    $imageName = time() . '.' . $image->getClientOriginalExtension();
    $image->storeAs('public/images', $imageName);

    return response()->json([
        'uploaded' => 1,
        'fileName' => $imageName
    ]);
});
