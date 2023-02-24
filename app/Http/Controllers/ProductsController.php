<?php

namespace App\Http\Controllers;

use App\Service\ProductService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class ProductsController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getProducts(): JsonResponse
    {
        $data = $this->productService->parseProducts();
        /** @var Collection $products */
        $products = $data['products'];

        $firstHalfRevenue = $products->filter(function ($item) {
            /** @var Carbon $date */
            $date = $item[ProductService::DATE_ADDED_COLUMN];
            return $date->day <= 15;
        })->sum(ProductService::PRICE_COLUMN);

        $secondHalfRevenue = $products->filter(function ($item) {
            /** @var Carbon $date */
            $date = $item[ProductService::DATE_ADDED_COLUMN];
            return $date->day > 15;
        })->sum(ProductService::PRICE_COLUMN);


        return response()->json([
            'products' => $products,
            'total_revenue' => round($products->sum('price'), 2),
            'first_half_revenue' => round($firstHalfRevenue, 2),
            'second_half_revenue' => round($secondHalfRevenue, 2),
            'total_products_count' => $products->count(),
            'categories' => $products->groupBy('category')->map(function ($item) {
                return [
                    'revenue' => round($item->sum('price'), 2),
                    'products_count' => $item->count()
                ];
            })
        ]);
    }

    public function renderProducts(): Response
    {
        $products = $this->productService->parseProducts();
        return response()->view('products', [
            'header' => $products['header'],
            'products' => $products['products']
        ]);
    }
}
