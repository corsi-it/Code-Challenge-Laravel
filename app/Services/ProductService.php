<?php

namespace App\Services;

class ProductService
{

    /**
     * @return array
     */
    public function parse(): array
    {
        $csvFilePath = storage_path('app/products.csv');

        $csvFile = fopen($csvFilePath, 'r');
        $header = fgetcsv($csvFile);
        $products = [];

        while (($row = fgetcsv($csvFile)) !== false) {
            $rowData = [];

            foreach ($header as $index => $field) {
                $rowData[$field] = $row[$index];
            }

            $products[] = $rowData;
        }
        fclose($csvFile);

        return $products;
    }
}
