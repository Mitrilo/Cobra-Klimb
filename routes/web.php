<?php

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

use App\Models\Image;

Route::get('/', function () {
    return view('home');
});
    // $images = Image::all();
    // foreach ($images as $image) {
    //     echo $image->image_path."<br>";
    //     echo $image->description."<br>";
    //     echo $image->user->name.' '.$image->user->surname."<br>";

    //     if (count($image->comments)>=1) {
    //         foreach ($image->comments as $comment) {
    //             echo $comment->user->name.' '.$comment->user->surname.': ';
    //             echo $comment->content.'<br>';
    //         }
    //     }

    //     // @if(Auth::user()->image)
    //     //     <div class="container-avatar">
    //     //         <img src="{{ route('user.avatar',['filename'=>Auth::user()->image])}}" class='avatar' width="45px" height="40px" style="border-radius: 50%;">
    //     //     </div>
    //     // @endif
    //     echo '<hr/>';
    // }
    


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'],function() {
    Route::get('/config', [App\Http\Controllers\ConfigController::class, 'form'])->name('config');
    Route::put('/config_update', [App\Http\Controllers\ConfigController::class, 'update'])->name('config_update');
    Route::get('/user/avatar/{filename}', [App\Http\Controllers\ConfigController::class, 'getImage'])->name('user.avatar');
    Route::get('/checkpw', [App\Http\Controllers\ConfigController::class, 'viewPassForm'])->name('checkpw');
    Route::post('/checkpwform', [App\Http\Controllers\ConfigController::class, 'checkPassw'])->name('checkpwform');
    Route::get('/changepw', [App\Http\Controllers\ConfigController::class, 'newPassword'])->name('changepw');
    Route::post('/changepwform', [App\Http\Controllers\ConfigController::class, 'passwordUpdate'])->name('changepwform');
    Route::get('/newimage', [App\Http\Controllers\ImageController::class, 'newImage'])->name('newimage');
    Route::put('/uploadimage', [App\Http\Controllers\ImageController::class, 'uploadImage'])->name('uploadimage');
    Route::get('/user/image/{filename}', [App\Http\Controllers\ImageController::class, 'getImages'])->name('user.image');
    Route::get('/home', [App\Http\Controllers\ImageController::class, 'index'])->name('home');
    Route::get('/', [App\Http\Controllers\ImageController::class, 'index'])->name('');


});
