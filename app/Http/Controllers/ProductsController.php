<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    //

    public function list(Request $request)
    {
        $products = Product::all();
        $categories = ProductCategory::all();
        $headers = Product::getPublicFields();
        return view("products", compact("products", "headers", "categories"));
    }


    public function jsonlist()
    {
        $dateS = \App\Models\Product::query()->min("date_added");
        $dateE = \App\Models\Product::query()->max("date_added");
        $startOfMonth = \Carbon\Carbon::createFromFormat("Y-m-d", $dateS)->startOfMonth();
        $endOfMonth = \Carbon\Carbon::createFromFormat("Y-m-d", $dateE)->endOfMonth();
        $midMonth = floor($endOfMonth->diffInDays($startOfMonth) / 2);

        $products = Product::all();
        $data = [
            "products" => $products,
            "categories" => ProductCategory::all()->map(function ($category) {
                return (object)[
                    "category_name" => $category->category,
                    "products_count" => $category->products()->count(),
                    "revenue" => $category->products()->sum('price')
                ];
            })->groupBy("category_name"),
            "total_products_count" => $products->count(),
            "first_half_revenue" => Product::query()
                ->whereBetween("date_added", [$startOfMonth, $startOfMonth->clone()->addDays($midMonth)])
                ->sum('price'),
            "second_half_revenue" => Product::query()
                ->whereBetween("date_added", [$endOfMonth->clone()->addDays(-1 * $midMonth), $endOfMonth])
                ->sum('price'),
            "total_revenue" => $products->sum("price"),
            "average_revenue" => $products->avg("price")
        ];

        return response()->json($data, 200);
    }
}
