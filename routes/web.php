<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\coco\CocoArticleController;
use App\Http\Controllers\shared\UploadFileController;
use App\Http\Controllers\coco\CocoNavController;
use App\Http\Controllers\coco\CocoCategoryController;
use App\Http\Controllers\coco\CocoFooterController;
use App\Http\Controllers\shared\ReorderController;
use App\Http\Controllers\TestController;
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
Route::resource('/test', TestController::class);


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('/users', UserController::class);
    Route::resource('/roles', RoleController::class);
    Route::resource('/products', ProductController::class);

    //咕咕雞商場
    Route::prefix('coco')->group(function () {
        //文章管理
        Route::resource('/coco_article', CocoArticleController::class);
        //導覽列管理
        Route::resource('/coco_nav', CocoNavController::class);
        Route::prefix('coco_nav_sort')->group(function () {
            Route::get('/reorder', [CocoNavController::class, 'reorder']);
        });
        //分類管理
        Route::resource('/coco_category', CocoCategoryController::class);
        Route::prefix('coco_category_sort')->group(function () {
            Route::get('/reorder', [CocoCategoryController::class, 'reorder']);
        });
        //footer管理
        Route::resource('/coco_footer', CocoFooterController::class);
        Route::prefix('coco_footer_sort')->group(function () {
            Route::get('/reorder', [CocoFooterController::class, 'reorder']);
        });
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
    Route::post('/save_reorder', [ReorderController::class,'save_reorder']);
    Route::post('/save_reorder_nav', [ReorderController::class,'save_reorder_nav']);
});