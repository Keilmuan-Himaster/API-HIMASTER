<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
   'as' => 'api.',
], function () {
   Route::get('/carousel', [App\Http\Controllers\Api\SliderController::class, 'index']);
   Route::get('/about/{category}', [App\Http\Controllers\Api\AboutController::class, 'about']);
   Route::get('/visi', [App\Http\Controllers\Api\AboutController::class, 'vision']);
   Route::get('/misi', [App\Http\Controllers\Api\AboutController::class, 'mission']);
   Route::get('/sejarah', [App\Http\Controllers\Api\AboutController::class, 'history']);
   Route::get('/mengenai', [App\Http\Controllers\Api\AboutController::class, 'mengenai']);
   Route::get('/divisi/{year}', [App\Http\Controllers\Api\StructureController::class, 'index']);
   Route::get('/member/{year}', [App\Http\Controllers\Api\MemberController::class, 'index']);
   Route::get('/member/{year}/{divisi}', [App\Http\Controllers\Api\MemberController::class, 'ondivisi']);
   Route::get('/berita', [App\Http\Controllers\Api\ContentController::class, 'index']);
   Route::get('/berita/{slug}', [App\Http\Controllers\Api\ContentController::class, 'show']);
   Route::get('/berita/kategori/{slug}', [App\Http\Controllers\Api\ContentController::class, 'indexByCategory']);
   Route::get('/category', [App\Http\Controllers\Api\ContentController::class, 'indexCategory']);
   Route::get('/kontak', [App\Http\Controllers\Api\ContactController::class, 'index']);
   Route::get('/galeri', [App\Http\Controllers\Api\GalleryController::class, 'index']);
   Route::get('/galeri/{name}', [App\Http\Controllers\Api\GalleryController::class, 'indexByStructure']);
   Route::get('/buster', [App\Http\Controllers\Api\BusterController::class, 'index']);
   Route::get('/youtube', [App\Http\Controllers\Api\YoutubeController::class, 'index']);
});
