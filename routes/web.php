<?php

use App\Models\Content;
use Illuminate\Support\Facades\Route;



Auth::routes();



Route::group([
   'prefix' => 'admin',
   'as' => 'backend.',
   'middleware' => 'auth',
], function () {
   Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
   Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
   Route::resource('timeline', App\Http\Controllers\Backend\TimelineController::class);

   //POST ROUTE
   Route::group([
      'prefix' => 'post',
      'as' => 'post.',
   ], function () {
      Route::resource('content', App\Http\Controllers\Backend\Post\ContentController::class);
      Route::get('content/getimage/{id}', [App\Http\Controllers\Backend\Post\ContentController::class, 'getImage']);
      Route::post('content/addimage', [App\Http\Controllers\Backend\Post\ContentController::class, 'addImage'])->name('addimage');
      Route::delete('content/deleteimage/{id}', [App\Http\Controllers\Backend\Post\ContentController::class, 'deleteImage'])->name('deleteimage');
      Route::post('content/edit/editimage', [App\Http\Controllers\Backend\Post\ContentController::class, 'editImage'])->name('editimage');
      Route::resource('category', App\Http\Controllers\Backend\Post\CategoryController::class);
      Route::resource('tag', App\Http\Controllers\Backend\Post\TagController::class);
      Route::resource('buster', App\Http\Controllers\Backend\Post\BusterController::class);
      Route::resource('gallery', App\Http\Controllers\Backend\Post\GalleryController::class);
   });

   Route::resource('slider', App\Http\Controllers\Backend\SliderController::class);
   //about
   Route::group([
      'prefix' => 'about',
      'as' => 'about.',
   ], function () {
      Route::resource('structure', App\Http\Controllers\Backend\About\StructureController::class);
      Route::resource('contact', App\Http\Controllers\Backend\About\ContactController::class);
      Route::resource('member', App\Http\Controllers\Backend\About\MemberController::class);
   });
});
