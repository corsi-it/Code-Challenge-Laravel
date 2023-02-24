<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/products', function () {
    return [
        "total_revenue" => 746.69,
        "first_half_revenue" => 438.82,
        "second_half_revenue" => 307.87,
        "total_products_count" => 31,
        "categories" => [
            "Electronics" => [
                "revenue" => 187.40,
                "products_count" => 10,
            ],
            "Books" => [
                "revenue" => 270.39,
                "products_count" => 11,
            ],
            "Clothing" => [
                "revenue" => 288.90,
                "products_count" => 10,
            ],
        ]
    ];
});
