<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\LazyCollection;

class ProcessProductFileService implements ProcessProductFileServiceInterface
{
    public function processFile(string $fileName): array
    {
        $report = [
            'total_revenue' => 0.00,
            'first_half_revenue' => 0.00,
            'second_half_revenue' => 0.00,
            'total_products_count' => 0,
            'categories' => [],
        ];

        $header = [];

        /**
         * TODO: Because CSV file can be rly big, HTTP conenction can time out, in that case, I will make
         * JOB process which will do that async for me, so user will not wait and will get notification when
         * processing file finished, so he can check report
         */

        if (Storage::exists($fileName)) {
            LazyCollection::make(function () use ($fileName) {
                $file = fopen(sprintf(Storage::path($fileName)), 'r');
                while ($data = fgetcsv($file)) {
                    yield $data;
                }
            })->each(function ($row, $index) use (&$report, &$header) {
                if ($index === 0) {
                    $header = $row;
                } else {
                    $product = array_combine($header, $row);

                    // Process csv row
                    $price = (double)$product['price'];
                    $report['total_revenue'] += $price;
                    $report['total_products_count']++;

                    $date = Carbon::parse($product['date_added']);
                    if (round($date->daysInMonth / 2) > $date->day) {
                        $report['first_half_revenue'] += $price;
                    } else {
                        $report['second_half_revenue'] += $price;
                    }

                    $categoryId = $product['category'];
//                    $categoryId = str_replace(' ', '_', trim(strtoupper($product['category'])));
                    if (isset($report['categories'][$categoryId])) {
                        $report['categories'][$categoryId]['products_count'] += 1;
                        $report['categories'][$categoryId]['revenue'] += $price;
                        $report['categories'][$categoryId]['revenueAvg'] = round($report['categories'][$categoryId]['revenue'] / $report['categories'][$categoryId]['products_count'], 2);
                    } else {
//                        $report['categories'][$categoryId]['name'] = $product['category'];
                        $report['categories'][$categoryId]['products_count'] = 1;
                        $report['categories'][$categoryId]['revenue'] = $price;
                        $report['categories'][$categoryId]['revenueAvg'] = $price;
                    }
                }
            });
        }

        return $report;
    }
}
