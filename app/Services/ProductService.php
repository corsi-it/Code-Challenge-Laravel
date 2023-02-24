<?php

namespace App\Services;

use Illuminate\Support\Collection;

class ProductService
{
    /**
     * This function returns total price of given products
     *
     * @param Collection $products
     * @return float
     */
    public function getTotalRevenue(Collection $products): float
    {
        $revenue =  $products->sum('price');
        return roundNumber($revenue, 2);
    }

    /**
     * This function returns total revenue in the first half of the month
     *
     * @param Collection $products
     * @return float
     */
    public function getFirstHalfRevenue(Collection $products): float
    {
        $revenue =  $products->filter(function ($product) {
            return isFirstHalfDate($product->date_added);
        })->sum('price');

        return roundNumber($revenue, 2);
    }

    /**
     * This function returns total revenue in the second half of the month
     *
     * @param Collection $products
     * @return float
     */
    public function getSecondHalfRevenue(Collection $products): float
    {
        $revenue =  $products->filter(function ($product) {
            return !isFirstHalfDate($product->date_added);
        })->sum('price');

        return roundNumber($revenue, 2);
    }


    /**
     * This function returns revenues and products couunts grouped by caterories
     *
     * @param Collection $products
     * @return array
     */
    public function getCategories(Collection $products): array
    {
        $categories = $products->groupBy('category')->map(function ($productsGroup) {
            return [
                'revenue' => $this->getTotalRevenue($productsGroup),
                'products_count' => $productsGroup->count()
            ];
        })->toArray();

        return $categories;
    }
}
