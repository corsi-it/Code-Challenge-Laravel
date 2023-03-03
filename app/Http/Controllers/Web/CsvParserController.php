<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Services\CsvParserService;
use Illuminate\Http\Request;
use function dd;
use function storage_path;

class CsvParserController extends Controller
{
    /** @var CsvParserService */
    private CsvParserService $csvParserService;

    public function __construct(CsvParserService $csvParserService)
    {
        $this->csvParserService = $csvParserService;
    }

    public function index(Request $request)
    {
        $fileName = storage_path() . "/app/products.csv";
        $parsedData = $this->csvParserService->parseCsvData($fileName);

        $processedData = $this->csvParserService->processParsedData($parsedData);

        return view('products', ['data' => $processedData]);
    }
}
