<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RoleController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [PostController::class,'index'])
->middleware(['auth','verified'])->name('dashboard');

//管理者用画面
Route::middleware(['auth','can:admin'])->group(function(){
    Route::get('/profile/index',[ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/adedit/{user}',[ProfileController::class, 'adedit'])->name('profile.adedit');
    Route::patch('/profile/adupdate/{user}',[ProfileController::class, 'adupdate'])->name('profile.adupdate');
    //追加
    Route::patch('roles/{user}/attach',[RoleController::class,'attach'])->name('role.attach');
    Route::patch('roles/{user}/detach',[RoleController::class,'detach'])->name('role.detach');
    Route::delete('/profile/addestroy/{user}',[ProfileController::class, 'addestroy'])->name('profile.addestroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('post/mycomment',[PostController::class,'mycomment'])->name('post.mycomment');
    Route::get('post/mypost',[PostController::class,'mypost'])->name('post.mypost');
    Route::resource('post',PostController::class);
    Route::post('post/comment/store',[CommentController::class,'store'])->name('comment.store');
});



Route::get('contact/create',[ContactController::class, 'create'])->name('contact.create');
Route::post('contact/store',[ContactController::class, 'store'])->name('contact.store');

require __DIR__.'/auth.php';
