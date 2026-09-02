<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InventoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_product_successfully(): void
    {
        $category = Category::create([
            'name' => 'Test Category',
            'description' => 'Test category',
        ]);

        $response = $this->postJson('/api/products', [
            'category_id' => $category->id,
            'name' => 'Test Product',
            'description' => 'Test product',
            'price' => 100,
            'quantity' => 10,
            'minimum_stock' => 5,
            'is_active' => true,
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonPath('success', true);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'quantity' => 10,
        ]);
    }

    public function test_reject_invalid_product(): void
    {
        $response = $this->postJson('/api/products', [
            'category_id' => 999,
            'name' => '',
            'price' => -10,
            'quantity' => -1,
        ]);

        $response->assertStatus(422);
    }

    public function test_stock_in_increases_quantity(): void
    {
        $category = Category::create([
            'name' => 'Test Category',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'price' => 100,
            'quantity' => 10,
            'minimum_stock' => 5,
            'is_active' => true,
        ]);

        $response = $this->postJson(
            "/api/products/{$product->id}/stock-in",
            [
                'quantity' => 20,
                'note' => 'Test stock in',
            ]
        );

        $response->assertStatus(200);

        $this->assertEquals(30, $product->fresh()->quantity);
    }

    public function test_stock_out_decreases_quantity(): void
    {
        $category = Category::create([
            'name' => 'Test Category',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'price' => 100,
            'quantity' => 10,
            'minimum_stock' => 5,
            'is_active' => true,
        ]);

        $response = $this->postJson(
            "/api/products/{$product->id}/stock-out",
            [
                'quantity' => 3,
                'note' => 'Test stock out',
            ]
        );

        $response->assertStatus(200);

        $this->assertEquals(7, $product->fresh()->quantity);
    }

    public function test_stock_out_greater_than_available_stock_is_rejected(): void
    {
        $category = Category::create([
            'name' => 'Test Category',
        ]);

        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Test Product',
            'price' => 100,
            'quantity' => 5,
            'minimum_stock' => 2,
            'is_active' => true,
        ]);

        $response = $this->postJson(
            "/api/products/{$product->id}/stock-out",
            [
                'quantity' => 10,
            ]
        );

        $response
            ->assertStatus(422)
            ->assertJsonPath('message', 'Insufficient stock');

        $this->assertEquals(5, $product->fresh()->quantity);
    }

    public function test_low_stock_report_returns_correct_products(): void
    {
        $category = Category::create([
            'name' => 'Test Category',
        ]);

        $lowStockProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'Low Stock Product',
            'price' => 100,
            'quantity' => 3,
            'minimum_stock' => 5,
            'is_active' => true,
        ]);

        $normalProduct = Product::create([
            'category_id' => $category->id,
            'name' => 'Normal Product',
            'price' => 100,
            'quantity' => 20,
            'minimum_stock' => 5,
            'is_active' => true,
        ]);

        $response = $this->getJson('/api/reports/low-stock');

        $response
            ->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonFragment([
                'id' => $lowStockProduct->id,
                'name' => 'Low Stock Product',
            ]);

        $response->assertJsonMissing([
            'id' => $normalProduct->id,
            'name' => 'Normal Product',
        ]);
    }
}
