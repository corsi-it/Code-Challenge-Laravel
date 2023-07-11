<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\ReportService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

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

    public function index(): Factory|View|Application
    {
        $products = $this->productService->getProducts();
        $reports = $this->reportService->getReports($products);
        return view('report', compact('products', 'reports'));
    }
}
