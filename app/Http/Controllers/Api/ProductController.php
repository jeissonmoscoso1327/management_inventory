<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(
        protected ProductsRepositoryInterface $productsRepositoryInterface
    ) {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        return $this->productsRepositoryInterface->getAll();
    }

    public function show($id)
    {
        $product = $this->productsRepositoryInterface->getById($id);
        if (! $product) {
            return response()->json(['message' => 'Product not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $product;
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], JsonResponse::HTTP_FORBIDDEN);
        }

        $validated = $request->validate([
            'category_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $product = $this->productsRepositoryInterface->create($validated);

        return response()->json([
            'message' => 'Successfully created product',
            'product' => $product,
        ], JsonResponse::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], JsonResponse::HTTP_FORBIDDEN);
        }

        $validated = $request->validate([
            'category_id' => 'sometimes|required|integer',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric',
            'stock' => 'sometimes|required|integer',
        ]);

        $product = $this->productsRepositoryInterface->update($id, $validated);

        if (! $product) {
            return response()->json(['message' => 'Product not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product,
        ], JsonResponse::HTTP_CREATED);
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Unauthorized'], JsonResponse::HTTP_FORBIDDEN);
        }

        $deleted = $this->productsRepositoryInterface->delete($id);
        if (! $deleted) {
            return response()->json(['message' => 'Product not found'], JsonResponse::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Product deleted']);
    }
}
