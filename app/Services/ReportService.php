<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReportService
{
    /**
     * Method: to get reports from products
     *
     * @param $products
     * @return object
     */
    public function getReports($products): object
    {
        return (object) [
            'total_revenue' => $this->getTotalRevenue($products),
            'first_half_revenue' => $this->getTotalRevenueInMonth($products, 'first_half'),
            'second_half_revenue' => $this->getTotalRevenueInMonth($products, 'second_half'),
            'total_products_count' => $this->getTotalNumberOfProducts($products),
            'categories' => $this->getAveragePriceOfProductsInEachCategory($products),
        ];
    }

    /**
     * Method: to get total revenue from products
     *
     * @param $products
     * @return float
     */
    public function getTotalRevenue($products): float
    {
        $revenue = $products->sum('price');
        return round($revenue, 2);
    }

    /**
     * Method: to get total revenue in a month from products
     *
     * @param $products
     * @param $durationType ('first_half'|'second_half')
     * @return float
     */
    public function getTotalRevenueInMonth($products, string $durationType): float
    {
        $revenue = $products->filter(function ($product) use ($durationType) {
            $day = Carbon::parse($product->date_added)->day;
            if ($durationType === 'first_half') return $day <= 15;
            return $day > 15;
        })->sum('price');

        return round($revenue, 2);
    }

    /**
     * Method: to get total number of products
     *
     * @param $products
     * @return int
     */
    public function getTotalNumberOfProducts($products): int
    {
        return $products->count();
    }


    /**
     * @param $products
     * @return Collection
     */
    public function getAveragePriceOfProductsInEachCategory($products): Collection
    {
        return $products->groupBy('category')->map(function ($product) {
            return [
                'revenue' => round($product->sum('price'), 2),
                'products_count' => $product->count(),
            ];
        });
    }

}
