<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('user', [AuthController::class, 'get_user']);

Route::post('login-app', [AuthController::class, 'login_app']);
Route::post('logout/{id}', [AuthController::class, 'logout']);

Route::post('get-orders', [OrderController::class, 'show_orders']);


Route::post('change-status/{id}', [OrderController::class, 'change_status']);

Route::post('store-rider-order/{rider_id}/{order_id}', [OrderController::class, 'store_rider_order']);


Route::post('get-rider-orders', [OrderController::class, 'get_rider_orders']);

Route::post('rider-order', [OrderController::class, 'get_rider_order']);



Route::get('qrcode-with-color', function () {
    // Generate the QR code as an SVG
    $qrcode = QrCode::size(300)->generate('https://mateen-ahmed.web.app/');

    // Convert the SVG QR code to base64
    $decodedData = base64_encode($qrcode);
    $encode = base64_decode($decodedData);

    // Define the image file path
    $imagePath = storage_path('app/public/base64_image.png'); // Change the file extension as needed

    // Save the decoded data as an image
    file_put_contents($imagePath, $encode);

    // Return the image in the response
    return response()->file($imagePath);
});


Route::post('/add-product', [OrderController::class, 'store_product']);
Route::post('/add-areas', [OrderController::class, 'add_areas']);

Route::post('/add-sub-categories', [OrderController::class,'store_sub_categories']);
Route::post('/store-addon', [OrderController::class,'store_addon']);
Route::post('/store-dressing', [OrderController::class,'store_dressing']);
Route::post('/store-types', [OrderController::class,'store_types']);



Route::post('accounts', [AdminController::class, 'accounts']);

