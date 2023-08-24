<?php

declare(strict_types=1);

namespace App\Service;

class ProductDataReader extends CSVReader
{
    private const HALF_MONTH = 15;

    private const PRODUCT_ID = 'product_id';
    private const PRODUCT_NAME = 'product_name';
    private const CATEGORY = 'category';
    private const PRICE = 'price';
    private const DATE_ADDED = 'date_added';

    public function __construct(private CSVReader $CSVReader)
    {}

    public function execute(string $path): array
    {
        $productData = $this->CSVReader->execute($path);

        return $this->elaborateProductData($productData);
    }

    private function elaborateProductData(array $productData): array
    {
        return [
            'categories' => $this->mapCategories($productData),
            'total_revenue' => $this->getTotalRevenue($productData),
            'total_products_count' => count($productData),
            'first_half_revenue' => $this->getProductRevenueByCallable(
                static fn($number) => $number <= self::HALF_MONTH,
                $productData
            ),
            'second_half_revenue' => $this->getProductRevenueByCallable(
                static fn($number) => $number > self::HALF_MONTH,
                $productData
            ),
        ];
    }

    private function getTotalRevenue(array $data): float
    {
        $value =  array_reduce(
            callback: static fn($sum, $row) => $row[self::PRICE] + $sum,
            array: $data,
            initial: 0
        );

        return $this->formatPrice($value);
    }

    private function mapCategories(array $data): array
    {
        $categoryList = $this->getCategoryList($data);
        $result = $this->getEmptyResult($categoryList);
        foreach ($data as $product) {
            $result[$product[self::CATEGORY]]['products_count']++;
            $result[$product[self::CATEGORY]]['revenue'] += $product[self::PRICE];
        }

        foreach ($result as $key => $category) {
            $result[$key]['revenue'] = $this->formatPrice($category['revenue']);
        }

        return $result;
    }

    private function getCategoryList(array $data): array
    {
        $categoryNames = array_map(
            callback: static fn($row) => $row[self::CATEGORY],
            array: $data
        );

        return array_unique($categoryNames);
    }

    private function getEmptyResult(array $categoryList): array
    {
        $result = [];

        foreach ($categoryList as $category) {
            $result[$category] = $this->categoryEmptyRow();
        }

        return $result;
    }

    private function categoryEmptyRow(): array
    {
        return [
            'products_count' => 0,
            'revenue' => 0,
        ];
    }

    private function getProductRevenueByCallable(callable $callable, array $productData): float
    {
        $productData = array_filter(
            callback: fn($product) => $callable($this->getDayFromDate($product[self::DATE_ADDED])),
            array: $productData
        );

        $productRevenue =  array_reduce(
            callback: static fn($sum, $row) => $row[self::PRICE] + $sum,
            array: $productData
        );

        return $this->formatPrice($productRevenue);
    }

    private function getDayFromDate(string $date): int
    {
        return (int) (new \DateTimeImmutable($date))->format('d');
    }
    private function formatPrice(int|float $price): float
    {
        return (float) number_format($price, 2);
    }

}
