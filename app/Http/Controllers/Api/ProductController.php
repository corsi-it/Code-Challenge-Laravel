<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProcessProductFileServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private ProcessProductFileServiceInterface $fileService;

    /**
     * @param ProcessProductFileServiceInterface $fileService
     */
    public function __construct(ProcessProductFileServiceInterface $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * @param string $fileName
     * @return JsonResponse
     */
    public function processFile(string $fileName = 'products.csv'): JsonResponse
    {
        return new JsonResponse($this->fileService->processFile($fileName));
    }
}
