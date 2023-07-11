<?php

namespace App\Services;

use Illuminate\Support\Collection;

class ProductService
{
    /**
     * Helper function to read CSV file
     *
     * @param $csvFile
     * @param string $delimiter
     * @return array
     */
    public function readCSV($csvFile, string $delimiter = ','): array
    {
        $lines = [];
        if (($file_handle = fopen($csvFile, 'r')) !== false) {
            while (($data = fgetcsv($file_handle, 0, $delimiter)) !== false) {
                $lines[] = $data;
            }
            fclose($file_handle);
        }
        return $lines;
    }

    /**
     * Method: to format CSV data with the first row as the field names
     *
     * @param $data
     * @return array
     */
    public function formatProductsData($data): array
    {
        $fields = $data[0];
        $dataArray = array_slice($data, 1);

        return array_map(function ($row) use ($fields) {
            return (object) array_combine($fields, $row);
        }, $dataArray);
    }

    /**
     * Method: to get products from CSV file
     *
     * @return Collection
     */
    public function getProducts(): Collection
    {
        $file = storage_path('app/products.csv');
        $products = $this->readCSV($file);
        return collect($this->formatProductsData($products));
    }

}
