<?php

namespace App\Service;

use Carbon\Carbon;

class ProductService
{
    public const DATE_ADDED_COLUMN = 'date_added';
    public const PRICE_COLUMN = 'price';
    public function parseProducts()
    {
        $csvFile = storage_path('/app/products.csv');
        $fileHandle = fopen($csvFile, 'r');
        while (!feof($fileHandle)) {
            $lineOfText[] = fgetcsv($fileHandle, 0, ',');
        }
        fclose($fileHandle);

        if (empty($lineOfText)) {
            return [
                'header' => [],
                'products' => []
            ];
        }

        $header = array_shift($lineOfText);

        $products = collect($lineOfText)->map(function ($item) use ($header) {
            $result = [];
            foreach ($header as $index => $value) {
                if ($value === self::DATE_ADDED_COLUMN) {
                    $result[$value] = Carbon::parse($item[$index]);
                    continue;
                }
                $result[$value] = $item[$index];
            }

            return $result;
        });

        return [
            'header' => $header,
            'products' => $products
        ];
    }
}
