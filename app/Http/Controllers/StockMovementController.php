<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockInRequest;
use App\Http\Requests\StockOutRequest;
use App\Models\Product;
use App\Models\StockMovement;

class StockMovementController extends Controller
{
    public function stockIn(StockInRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->quantity += $request->quantity;
        $product->save();

        $movement = StockMovement::create([
            'product_id' => $product->id,
            'type' => 'IN',
            'quantity' => $request->quantity,
            'note' => $request->note,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Stock added successfully',
            'data' => [
                'product' => $product,
                'movement' => $movement,
            ],
        ]);
    }

    public function stockOut(StockOutRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($request->quantity > $product->quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock',
            ], 422);
        }

        $product->quantity -= $request->quantity;
        $product->save();

        $movement = StockMovement::create([
            'product_id' => $product->id,
            'type' => 'OUT',
            'quantity' => $request->quantity,
            'note' => $request->note,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Stock removed successfully',
            'data' => [
                'product' => $product,
                'movement' => $movement,
            ],
        ]);
    }

    public function movements($id)
    {
        $product = Product::findOrFail($id);

        $movements = $product->movements()->latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Stock movements retrieved successfully',
            'data' => $movements,
        ]);
    }
}
