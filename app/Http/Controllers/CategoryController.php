<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Http\Requests\UpdateCategoryRequest;


class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'message' => 'Categories retrieved successfully',
            'data' => $categories,
        ]);
    }
    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }
    public function show($id)
{
    $category = Category::findOrFail($id);

    return response()->json([
        'success' => true,
        'message' => 'Category retrieved successfully',
        'data' => $category,
    ]);
}
public function update(UpdateCategoryRequest $request, $id)
{
    $category = Category::findOrFail($id);

    $category->update($request->validated());

    return response()->json([
        'success' => true,
        'message' => 'Category updated successfully',
        'data' => $category,
    ]);
}
public function destroy($id)
{
    $category = Category::findOrFail($id);

    $category->delete();

    return response()->json([
        'success' => true,
        'message' => 'Category deleted successfully',
    ]);
}
}
