<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Testing\Fluent\AssertableJson;

class ProductsTest extends TestCase
{
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->getJson('/api/products');

        $response->assertStatus(200);
    }

    public function test_total_revenue_is_returned()
    {
        $response = $this->getJson('/api/products');
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('total_revenue', fn($actual) => $this->floatEquals($actual, 746.69))
            ->whereType('total_revenue', 'double')
            ->etc()
        );
    }

    public function test_average_revenue_is_returned()
    {
        $response = $this->getJson('/api/products');
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('average_revenue', fn($actual) => $this->floatEquals($actual, 24.086774193548393))
            ->whereType('average_revenue', 'double')
            ->etc()
        );
    }

    public function test_first_half_revenue_is_returned()
    {
        $response = $this->getJson('/api/products');
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('first_half_revenue', fn($actual) => $this->floatEquals($actual, 438.82))
            ->whereType('first_half_revenue', 'double')
            ->etc()
        );
    }

    public function test_second_half_revenue_is_returned()
    {
        $response = $this->getJson('/api/products');
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('second_half_revenue', fn($actual) => $this->floatEquals($actual, 307.87))
            ->whereType('second_half_revenue', 'double')
            ->etc()
        );
    }

    public function test_total_products_count_is_returned()
    {
        $response = $this->getJson('/api/products');
        $response->assertJson(fn(AssertableJson $json) => $json
            ->where('total_products_count', 31)
            ->whereType('total_products_count', 'integer')
            ->etc()
        );
    }

    public function test_category_revenue_is_returned()
    {
        $response = $this->getJson('/api/products');
        $response->assertJson(fn(AssertableJson $json) => $json
            ->whereType('categories', 'array')
            ->where('categories.Electronics.revenue', fn($actual) => $this->floatEquals($actual, 187.40))
            ->whereType('categories.Electronics.revenue', 'double')
            ->where('categories.Books.revenue', fn($actual) => $this->floatEquals($actual, 270.39))
            ->whereType('categories.Books.revenue', 'double')
            ->where('categories.Clothing.revenue', fn($actual) => $this->floatEquals($actual, 288.90))
            ->whereType('categories.Clothing.revenue', 'double')
            ->etc()
        );
    }

    public function test_category_products_count_is_returned()
    {
        $response = $this->getJson('/api/products');
        $response->assertJson(fn(AssertableJson $json) => $json
            ->whereType('categories', 'array')
            ->where('categories.Electronics.products_count', 10)
            ->whereType('categories.Electronics.products_count', 'integer')
            ->where('categories.Books.products_count', 11)
            ->whereType('categories.Books.products_count', 'integer')
            ->where('categories.Clothing.products_count', 10)
            ->whereType('categories.Clothing.products_count', 'integer')
            ->etc()
        );
    }


}
