<?php

namespace App\Http\Controllers;

use App\Services\ProcessProductFileServiceInterface;

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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function processFile(string $fileName = 'products.csv')
    {
        return view('product_report', [
            'report' => $this->fileService->processFile($fileName)
        ]);
    }
}
