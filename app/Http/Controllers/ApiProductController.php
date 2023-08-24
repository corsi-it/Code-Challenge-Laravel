<?php

declare(strict_types=1);

namespace App\Http\Controllers;


use App\Service\ProductDataReader;
use Illuminate\Http\JsonResponse;

class ApiProductController extends Controller
{
    public function index(ProductDataReader $apiProductFormatter): JsonResponse
    {
        return \response()->json(
            $apiProductFormatter->execute('app/products.csv')
        );
    }
}
