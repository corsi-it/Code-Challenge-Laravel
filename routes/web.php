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

/*
   $csvFile = storage_path('app/products.csv');

   $csv = array_map('str_getcsv', file($csvFile));
   array_walk($csv, function(&$a) use ($csv) {
       $a = array_combine($csv[0], $a);
   });
   array_shift($csv);
   */

Route::get('/', function () {
    // return your computed table here

    /* non sono riuscito a testare perchè mi si impallava laravel,
    per sbrigarmi e fare i test ho riportato la stessa funzione di lettura del file csv
    $client = new GuzzleHttp\Client();
    $url = URL::to('/') . '/api/products';
    $response = $client->get($url);

    // Elaborazione della risposta
    $csv = json_decode($response->getBody(), true);
    */

    $csvFile = storage_path('app/products.csv');

    $csv = array_map('str_getcsv', file($csvFile));
    array_walk($csv, function(&$a) use ($csv) {
        $a = array_combine($csv[0], $a);
    });
    array_shift($csv);

    $totalRevenue = 0;
    $totalRevenueFirstHalf = 0;
    $totalRevenueSecondHalf = 0;
    $categories = array();
    $categorySums = array();
    $categoryCounts = array();
    //product_id,product_name,category,price,date_added

    foreach ($csv as $row) {
        $totalRevenue += $row['price'];

        $category = $row['category'];

        if(!array_key_exists($category, $categories)) {
            $categories[$category] = 1;
            $categorySums[$category] = 0;
            $categoryCounts[$category] = 0;
        }
        $categorySums[$category] += $row['price'];
        $categoryCounts[$category]++;
        $dateAdded = $row['date_added'];
        $firstHalf = intval(substr($dateAdded, -2)) <= 15;
        if ($firstHalf) {
            $totalRevenueFirstHalf += $row['price'];
        } else {
            $totalRevenueSecondHalf += $row['price'];
        }
    }


    return view('prodotti', [
        'prodotti' => $csv,
        'totalRevenue' => $totalRevenue,
        'totalRevenueFirstHalf' => $totalRevenueFirstHalf,
        'totalRevenueSecondHalf' => $totalRevenueSecondHalf,
        'categories' => $categories,
        'categorySums' => $categorySums,
        'categoryCounts' => $categoryCounts
    ]);
});
