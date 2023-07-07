<?php

namespace App\Services;

use Illuminate\Support\Collection;

class ProductService
{

    /**
     * @return Collection
     */
    public function parse(): Collection
    {
        $csvFilePath = storage_path('app/products.csv');

        $csvFile = fopen($csvFilePath, 'r');
        $header = fgetcsv($csvFile);

        $products = new Collection();

        while (($row = fgetcsv($csvFile)) !== false) {
            $rowData = [];

            foreach ($header as $index => $field) {
                $rowData[$field] = $row[$index];
            }

            $products->push($rowData);
        }
        fclose($csvFile);

        return $products;
    }

    /**
     * @param $products
     *
     * @return float
     */
    function getTotalRevenue($products): float
    {
        $totalRevenue = floatval($products->sum('price'));

        return $totalRevenue;
    }


    /**
     * @param $products
     *
     * @return float
     */
    function getTotalRevenueInFirstHalfOfMonth($products): float
    {
        $firstHalfRevenue = floatval($products->filter(function ($product) {
            $day = intval(date('d', strtotime($product['date_added'])));
            return $day <= 15;
        })->sum('price'));

        return $firstHalfRevenue;
    }

    /**
     * @param $products
     *
     * @return float
     */
    function getTotalRevenueInSecondHalfOfMonth($products): float
    {
        $secondHalfRevenue = floatval($products->filter(function ($product) {
            $day = intval(date('d', strtotime($product['date_added'])));
            return $day > 15;
        })->sum('price'));

        return $secondHalfRevenue;
    }

    /**
     * @param $products
     *
     * @return Collection
     */
    function getCountOfProductsInCategories($products):Collection
    {
        $categoryCounts = $products->groupBy('category')->map(function ($items) {
            return $items->count();
        });
        return $categoryCounts;
    }

    /**
     * @param $products
     *
     * @return Collection
     */
    function getAveragePriceByCategory($products): Collection
    {
        $categoryAverages = $products->groupBy('category')->map(function ($items) {
            return $items->avg('price');
        });

        return $categoryAverages;
    }

}
