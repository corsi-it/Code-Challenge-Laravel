<?php

namespace App\Http\Controllers;

use App\Services\CSVService;
use App\Services\ProductService;

class ProductController extends Controller
{
    private $csvService, $productService;

    public function __construct(CSVService $csvService, ProductService $productService)
    {
        $this->csvService = $csvService;
        $this->productService = $productService;
    }

    public function index()
    {
        $productCSVFile = storage_path() . '/app/products.csv';

        $products = $this->csvService->getProducts($productCSVFile);
        $totalRevenue = $this->productService->getTotalRevenue($products);
        $firstHalfRevenue = $this->productService->getFirstHalfRevenue($products);
        $secondHalfRevenue = $this->productService->getSecondHalfRevenue($products);
        $totalProductCount = $products->count();
        $categories = $this->productService->getCategories($products);

        $result = [
            'total_revenue' => $totalRevenue,
            'first_half_revenue' => $firstHalfRevenue,
            'second_half_revenue' => $secondHalfRevenue,
            'total_products_count' => $totalProductCount,
            'categories' => $categories
        ];

        return $result;
    }
}
