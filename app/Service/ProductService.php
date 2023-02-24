<?php

namespace App\Service;

use Carbon\Carbon;

class ProductService
{
    public function parseProducts()
    {
        $csvFile = storage_path('/app/products.csv');
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle)) {
            $line_of_text[] = fgetcsv($file_handle, 0, ',');
        }
        fclose($file_handle);

        if (empty($line_of_text)) {
            return [
                'header' => [],
                'products' => []
            ];
        }

        $header = array_shift($line_of_text);
        $items = collect();
        foreach ($line_of_text as $value) {
            $item = [];
            foreach ($header as $index => $val) {
                if ($val === 'date_added') {
                    $item[$val] = Carbon::parse($value[$index]);
                    continue;
                }
                $item[$val] = $value[$index];
            }
            $items->push($item);
        }

        return [
            'header' => $header,
            'products' => collect($items)
        ];
    }
}
