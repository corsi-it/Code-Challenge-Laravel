<?php

namespace App\Services;
use App\Interfaces\ReadFileInterface;
use Illuminate\Support\Collection;

class ReadFileService implements ReadFileInterface
{
    /**
     * @var Collection
     */
    public Collection $data;

    /**
     * @return Collection
     */
    public function readCSV(): Collection
    {
        $file = storage_path('app/products.csv');
        $mappedData = array_map('str_getcsv', file($file));
        $data = [];
        foreach ($mappedData as $index => $row) {
            if ($index === 0) {
                continue;
            }
            $data[] = [
                'product_id' => $row[0],
                'product_name' => $row[1],
                'category' => $row[2],
                'price' => $row[3],
                'date_added' => $row[4],
            ];
        }
        $this->data = collect($data);
        return collect($data);
    }

    /**
     * @return float
     * Total revenue of all products
     */
    public function totalRevenueOfAllProducts(): float
    {
        $data = $this->data;
        return round($data->sum('price'), 2);
    }

    /**
     * @return float
     * Total revenue in the first half of the month
     */
    public function totalRevenueInFirstHalfOfMonth(): float
    {
        $data = $this->data;
        return round($data->whereBetween('date_added', ['2022-01-01', '2022-01-15'])->sum('price'), 2);
    }

    /**
     * @return float
     * Total revenue in the second half of the month
     */
    public function totalRevenueInSecondHalfOfMonth(): float
    {
        $data = $this->data;
        return round($data->whereBetween('date_added', ['2022-01-16', '2022-01-31'])->sum('price'),2);
    }

    /**
     * @return array
     * Average price of products in each category
     */
    public function averagePriceOfProductsInEachCategory(): array
    {
        $data = $this->data;
        $categories = $data->pluck('category')->unique();
        $result = [];
        foreach ($categories as $category) {
            $result[$category] = [
                'revenue' => round($data->where('category', $category)->sum('price'), 2),
                'products_count' => $data->where('category', $category)->count()
            ];

        }
        return $result;
    }
}
