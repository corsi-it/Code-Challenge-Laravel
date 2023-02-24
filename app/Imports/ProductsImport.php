<?php

namespace App\Imports;

use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProductsImport implements ToCollection
{
    /**
     * @param Collection $rows
     *  @void
     */
    public function collection(Collection $rows): void
    {
        if( !Category::query()->first()) {
            foreach ($rows as $k => $row) {

                if (!$k) {
                    continue;
                }
                $category = Category::query()->firstOrCreate(['name' => $row[2]]);
                $prodData = [
                    'id' => $row[0],
                    'name' => $row[1],
                    'price' => $row[3],
                    'created_at' => $row[4],
                ];
                $category->products()->create($prodData);
            }
        }
        $sum = $this->getTotal();
        $halfMonth = $this->getHalfMonthRevenue();
        $html = view('products', compact('rows'))->render();
        Storage::disk('local')->put('products.html', $html);
    }

    /**
     * @return float
     */
    public function getTotal(): float
    {
       return Product::query()->sum('price');
    }

    /**
     * @return float
     */
    public function getHalfMonthRevenue(): float
    {
        $date = Carbon::parse('2022-01');
        $date->addDays(15);

        return Product::query()->where('created_at', '<=', $date)->sum('price');
    }
}
