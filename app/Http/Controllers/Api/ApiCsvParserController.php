<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\CsvParserService;
use Illuminate\Http\Request;
use function dd;
use function storage_path;

class ApiCsvParserController extends Controller
{
    /** @var CsvParserService */
    private CsvParserService $csvParserService;

    public function __construct(CsvParserService $csvParserService)
    {
        $this->csvParserService = $csvParserService;
    }

    public function products(Request $request)
    {
        $fileName = storage_path() . "/app/products.csv";
        $parsedData = $this->csvParserService->parseCsvData($fileName);

        return $this->csvParserService->processParsedData($parsedData);
    }
}
