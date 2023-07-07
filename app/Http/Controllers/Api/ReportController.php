<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProductService;
use App\Services\ReportService;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    /**
     * Injecting services to controller
     *
     * @param ProductService $productService
     * @param ReportService $reportService
     */
    public function __construct(
        private ProductService $productService,
        private ReportService $reportService
    )
    {
    }

    public function products(): JsonResponse
    {
        $products = $this->productService->getProducts();
        $reports = $this->reportService->getReports($products);
        return response()->json($reports);
    }
}
