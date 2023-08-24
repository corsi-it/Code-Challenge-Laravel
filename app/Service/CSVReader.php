<?php

declare(strict_types=1);

namespace App\Service;

class CSVReader
{
    public function execute(string $path): array
    {
        $filePath = storage_path($path);

        $file = fopen($filePath, 'rb');

        $header = fgetcsv($file);

        $data = [];

        while ($row = fgetcsv($file)) {
            $data[] = array_combine($header, $row);
        }

        return $data;
    }
}
