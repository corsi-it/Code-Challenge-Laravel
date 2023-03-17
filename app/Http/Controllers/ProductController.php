<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function data() {
        //leggi file csv
        $pathToCSVFile = storage_path() . '/app/products.csv';

        $products = [];
        $file = fopen($pathToCSVFile, 'r');

        $headers = fgetcsv($file);




        while (($row = fgetcsv($file)) !== FALSE) {
            $productsArray[] = (object) array_combine($headers, $row);
        }

        fclose($file);

        $products = collect($productsArray);

        $cmp = function ($p) {
            $isFirstHalf = intval(explode('-',$p->date_added)[2]) < 16;
            return $isFirstHalf;
        };

        //revenues
        $totalRevenues = $products->sum('price');
        $totalRevenuesFirstHalf = $products->filter( $cmp )->sum('price');
        $totalRevenuesSecondHalf = $products->reject( $cmp )->sum('price');

        //categories
        $categoriesGroup = $products->groupBy('category');


        $statsPerCategory = ($categoriesGroup->map(function ($groupProducts) {

            $categoryItem = $groupProducts->first->category;
            return (object) array_combine(
                ['category_name', 'average_price', 'product_count'],
                [
                    $categoryItem->category,
                    $groupProducts->sum('price') / $groupProducts->count(),
                    $groupProducts->count()
                ]);

        }));

        return [
            'products' => collect($products),
            'total' => $totalRevenues,
            'totalFirstHalf' => $totalRevenuesFirstHalf,
            'totalSecondHalf' => $totalRevenuesSecondHalf,
            'statsPerCategory' => $statsPerCategory
        ];
    }
    public function index() {






        return view('table',$this->data());



    }
}
