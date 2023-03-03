<?php

namespace App\Http\Services;

class CsvParserService
{
    public function parseCsvData($fileName): array
    {
        $products = [];

        if (($open = fopen($fileName, "r")) !== false) {
            while (($data = fgetcsv($open, 1000, ",")) !== false) {
                $products[] = $data;
            }

            fclose($open);
        }

        if (empty($products)) {
            return [];
        }

        $columnNames = $products[0];
        unset($products[0]);

        $allProducts = [];
        foreach ($products as $productData) {
            $data = [];
            foreach ($productData as $key => $item) {
                $data[$columnNames[$key]] = $item;
            }
            $allProducts[] = $data;
        }

        return $allProducts;
    }

    public function processParsedData(array $data): array
    {
        $categoriesData = [];
        $totalSum = 0;
        $totalCount = 0;
        $totalPriceFirstHalf = 0;
        $totalPriceSecondHalf = 0;

        foreach ($data as $productItem) {
            $day = explode('-', $productItem['date_added'])[2];
            if ($day <= 15) {
                $totalPriceFirstHalf += $productItem['price'];
            }
            if ($day > 15) {
                $totalPriceSecondHalf += $productItem['price'];
            }

            $category = $productItem['category'];
            $totalNumber = 0;
            $totalPrice = 0;
            if (!empty($categoriesData[$category])) {
                $totalNumber = $categoriesData[$category]['products_count'];
                $totalPrice = $categoriesData[$category]['revenue'];
            }

            $totalNumber++;
            $totalPrice += $productItem['price'];
            $average = $totalPrice / $totalNumber;

            $totalCount++;
            $totalSum += $productItem['price'];

            $categoriesData[$category] = [
                'products_count' => $totalNumber,
                'average'        => $average,
                'revenue'        => $totalPrice
            ];
        }

        return [
            'products'             => $data,
            'categories'           => $categoriesData,
            'total_products_count' => $totalCount,
            'total_revenue'        => $totalSum,
            'first_half_revenue'   => $totalPriceFirstHalf,
            'second_half_revenue'  => $totalPriceSecondHalf
        ];
    }
}
