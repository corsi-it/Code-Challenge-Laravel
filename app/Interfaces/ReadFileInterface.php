<?php

namespace App\Interfaces;

use Illuminate\Support\Collection;

interface ReadFileInterface
{
    /**
     * @return Collection
     */
    public function readCSV(): Collection;

    /**
     * @return float
     */
    public function totalRevenueOfAllProducts(): float;

    /**
     * @return float
     */
    public function totalRevenueInFirstHalfOfMonth(): float;

    /**
     * @return float
     */
    public function totalRevenueInSecondHalfOfMonth():float;

    /**
     * @return array
     */
    public function averagePriceOfProductsInEachCategory(): array;
}
