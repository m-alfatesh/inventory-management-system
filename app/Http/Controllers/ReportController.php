<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ReportController extends Controller
{
    public function lowStock()
    {
        $products = Product::whereColumn('quantity', '<=', 'minimum_stock')->get();

        return response()->json([
            'success' => true,
            'message' => 'Low stock products retrieved successfully',
            'data' => $products,
        ]);
    }

    public function outOfStock()
    {
        $products = Product::where('quantity', 0)->get();

        return response()->json([
            'success' => true,
            'message' => 'Out of stock products retrieved successfully',
            'data' => $products,
        ]);
    }

    public function summary()
    {
        $totalProducts = Product::count();

        $activeProducts = Product::where('is_active', true)->count();

        $outOfStock = Product::where('quantity', 0)->count();

        $lowStock = Product::whereColumn('quantity', '<=', 'minimum_stock')->count();

        return response()->json([
            'success' => true,
            'message' => 'Inventory summary retrieved successfully',
            'data' => [
                'total_products' => $totalProducts,
                'active_products' => $activeProducts,
                'out_of_stock' => $outOfStock,
                'low_stock' => $lowStock,
            ],
        ]);
    }
}
