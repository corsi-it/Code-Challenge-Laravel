<?php

namespace App\Services;

use Illuminate\Support\Collection;

class CSVService
{
    /**
     * This function returns products from given CSV file as a collection
     *
     * @param string $productCSVFile
     * @return Collection
     */
    public function getProducts(string $productCSVFile): Collection
    {
        $products = [];
        $file = fopen($productCSVFile, 'r');

        $headers = fgetcsv($file);

        while (($row = fgetcsv($file)) !== FALSE) {
            $products[] = (object) array_combine($headers, $row);
        }

        fclose($file);
        return collect($products);
    }
}
