<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class fillProducts extends Command
{
    protected $signature = 'corsi:importcsv {file?}';
    protected $description = 'fill products from csv ';

    const delimiter = ",";
    const maxLength = 10000;


    public function handle()
    {
        $argFile = $this->argument("file");
        if (empty($argFile)) {
            $argFile = "products.csv";
        }

        $storage = Storage::disk('');
        if (!$storage->exists($argFile)) {
            $this->error("File {$argFile}, not exists");
            return Command::FAILURE;
        }

        $handle = $storage->readStream($argFile);
        if (empty($handle)) {
            $this->error("Cannot read {$argFile} file.");
            return Command::FAILURE;
        }
        $headers = $this->getHeaders($handle);
        $rows = $this->getLines($handle, $headers);
        fclose($handle);
        unset($headers);

        $categoryCache = [];
        foreach ($rows as $row) {
            $pid = $row["product_id"];
            $category = $row["category"];
            $categoryObj = isset($categoryCache[$category]) ? $categoryCache[$category] : null;
            if (empty($categoryObj)) {
                $categoryObj = ProductCategory::query()->where("category", $category)->first();
                if (empty($categoryObj)) {
                    $categoryObj = ProductCategory::make();
                    $categoryObj->category = $category;
                    $categoryObj->save();
                }
                $categoryCache[$category] = $categoryObj;
            }

            $product = Product::find($pid);
            if (empty($product)) {
                $product = Product::make();
            }
            unset($row["product_id"]);
            unset($row["category"]);
            foreach ($row as $key => $value) {
                $product->{$key} = $value;
            }
            $product->product_category_id = $categoryObj->getKey();
            $product->save();
        }


        return Command::SUCCESS;
    }

    private function getHeaders($stream)
    {
        return fgetcsv($stream, self::maxLength, self::delimiter);
    }

    private function getLines($stream, $headers)
    {
        $preventLoop = 10000000;
        $lines = [];
        while (($row = fgetcsv($stream, self::maxLength, self::delimiter)) !== FALSE) {
            if ($preventLoop < 0) {
                break;
            }
            if ($row !== FALSE) {
                $lines[] = array_combine($headers, $row);
            } else {
                break;
            }
            $preventLoop -= 1;
        }
        return $lines;
    }

}
