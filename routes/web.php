<?php

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

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Illuminate\Support\Str;


Route::get('/', function () {
    return view('welcome');
});

Route::post('/', function (Request $request) {
    $imageFile = $request->myfile;
    $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
    $imageFile->move(public_path('uploads'), $imageName);

    $manager = new ImageManager(Driver::class);
    $image = $manager->read(public_path() . '/uploads/' . $imageName);
    $name =  public_path() . '/compressed_images/' . Str::uuid() . '.webp';
    $image->scaleDown(width: 300);
    $image->save($name, quality: 80);
});
