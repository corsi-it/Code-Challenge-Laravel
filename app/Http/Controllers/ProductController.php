<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
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
     * @return Factory|View|Application
     */
    public function products(Request $request): Factory|View|Application
    {
        $products = $this->productService->parse();
        return view('products')->with('products', $products);
    }

    public function reports(Request $request)
    {
        $products = $this->productService->parse();
        $totalRevenue = $this->productService->getTotalRevenue($products);
        $firstHalfRevenue = $this->productService->getTotalRevenueInFirstHalfOfMonth($products);
        $secondHalfRevenue = $this->productService->getTotalRevenueInSecondHalfOfMonth($products);
        $numberOfProductsInCategories = $this->productService->getCountOfProductsInCategories($products);
        $averagePriceByCategory = $this->productService->getAveragePriceByCategory($products);

        return view('reports', compact(
            'products',
            'totalRevenue',
            'firstHalfRevenue',
            'secondHalfRevenue',
            'numberOfProductsInCategories',
            'averagePriceByCategory'
        ));
    }
}
