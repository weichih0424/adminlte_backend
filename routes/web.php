<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\coco\CocoArticleController;
use App\Http\Controllers\shared\UploadFileController;
use App\Http\Controllers\coco\CocoCategoryController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [HomeController::class, 'index'])->name('home');

// Route::group(['middleware' => ['auth']], function() {
//     Route::resource('/roles', RoleController::class);
//     Route::resource('/users', UserController::class);
//     Route::resource('/products', ProductController::class);
// });
Auth::routes();

Route::get('/', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::get('/admin', [HomeController::class, 'index'])->name('admin');


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('/users', UserController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/products', ProductController::class);

    //咕咕雞商場
    Route::prefix('coco')->group(function () {
        Route::resource('/coco_article', CocoArticleController::class);
        Route::resource('/coco_category', CocoCategoryController::class);
    });
});

Route::prefix('shared')->middleware('auth')->group(function () {
    // //圖片裁切
    // Route::prefix('image_crop')->group(function () {
    //     Route::post('/img_save_to_file', [ImageCropController::class,'img_save_to_file']);
    //     Route::post('/img_crop_to_file', [ImageCropController::class,'img_crop_to_file']);
    // });
    //圖片上傳套件
    Route::prefix('fileupload')->group(function () {
        Route::post('/upload_file', [UploadFileController::class,'upload_file']);
        Route::post('/delete_file', [UploadFileController::class,'delete_file']);
    });
    // //共用儲存排序
    // Route::post('/save_reorder', [ReorderController::class,'save_reorder']);
});