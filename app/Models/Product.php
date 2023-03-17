<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        "product_name",
        "product_category_id",
        "price",
        "date_added"
    ];

    public function category()
    {
        return $this->belongsTo(ProductCategory::class, "product_category_id");
    }


    public function getData($fieldorMethod)
    {
        if (method_exists($this, $fieldorMethod)) {
            return call_user_func([$this, $fieldorMethod]);
        }
        return $this->getAttribute($fieldorMethod);
    }

    public function getCategoryName()
    {
        return $this->category->category;
    }

    public static function getPublicFields()
    {
        return [
            "product_name" => "product_name",
            "category" => "getCategoryName",
            "price" => "price",
            "date_added" => "date_added"
        ];
    }


}

