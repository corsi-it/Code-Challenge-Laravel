<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    private ProductService $productService;

    /**
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function products(Request $request): \Illuminate\Http\JsonResponse
    {
        $products = $this->productService->parse();
        $totalRevenue = $this->productService->getTotalRevenue($products);
        $firstHalfRevenue = $this->productService->getTotalRevenueInFirstHalfOfMonth($products);
        $secondHalfRevenue = $this->productService->getTotalRevenueInSecondHalfOfMonth($products);
        $numberOfProductsInCategories = $this->productService->getCountOfProductsInCategories($products);
        $averagePriceByCategory = $this->productService->getAveragePriceByCategory($products);


        return response()->json([
            'data' => $products,
            'total_revenue' => $totalRevenue,
            'first_half_revenue' => $firstHalfRevenue,
            'second_half_revenue' => $secondHalfRevenue,
            'total_products_count' => $products->count(),
            'categories' => $numberOfProductsInCategories->mergeRecursive($averagePriceByCategory),
        ]);
    }
}
