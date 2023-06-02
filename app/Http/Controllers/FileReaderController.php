<?php

namespace App\Http\Controllers;

use App\Interfaces\ReadFileInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class FileReaderController extends Controller
{
    /**
     * @var ReadFileInterface
     */
    private ReadFileInterface $readFile;

    /**
     * @var array
     */
    protected array $data;

    /**
     * @var View
     */
    function __construct(ReadFileInterface $readFile)
    {
        $this->readFile = $readFile;
        $this->readFile->readCSV();
        $this->data = [
            'total_revenue' => $this->readFile->totalRevenueOfAllProducts(),
            'first_half_revenue' => $this->readFile->totalRevenueInFirstHalfOfMonth(),
            'second_half_revenue' => $this->readFile->totalRevenueInSecondHalfOfMonth(),
            'total_products_count' => $this->readFile->data->count(),
            'categories' => $this->readFile->averagePriceOfProductsInEachCategory(),
        ];
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json($this->data);
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('table', $this->data);
    }
}
