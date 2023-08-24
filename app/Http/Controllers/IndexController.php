<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Service\CSVReader;
use App\Service\ProductDataReader;
use Illuminate\View\View;

class IndexController
{
    public function index(ProductDataReader $productReader): View
    {
        $data = $productReader->execute('app/products.csv');

        return view('index', ['data' => $data]);
    }
}
