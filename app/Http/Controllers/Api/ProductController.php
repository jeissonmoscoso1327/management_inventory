<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProductController extends Controller
{
    public function __construct(
        protected ProductsRepositoryInterface $productsRepositoryInterface
    ) {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        try {
            return $this->productsRepositoryInterface->getAll();
        } catch (Throwable $e) {
            Log::error(
                'ProductController::index()',
                [
                    'exception' => $e,
                ]
            );
        }
    }

    public function show(int $id)
    {
        try {
            $product = $this->productsRepositoryInterface->getById($id);
            if (! $product) {
                return response()->json(['message' => 'Product not found'], JsonResponse::HTTP_NOT_FOUND);
            }

            return $product;
        } catch (Throwable $e) {
            Log::error(
                'ProductController::show()',
                [
                    'exception' => $e,
                ]
            );
        }
    }

    public function store(Request $request)
    {
        try {
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
        } catch (Throwable $e) {
            Log::error(
                'ProductController::store()',
                [
                    'exception' => $e,
                ]
            );
        }
    }

    public function update(Request $request, int $id)
    {
        try {
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
        } catch (Throwable $e) {
            Log::error(
                'ProductController::update()',
                [
                    'exception' => $e,
                ]
            );
        }
    }

    public function destroy(int $id)
    {
        try {
            if (Auth::user()->role !== 'admin') {
                return response()->json(['message' => 'Unauthorized'], JsonResponse::HTTP_FORBIDDEN);
            }

            $deleted = $this->productsRepositoryInterface->delete($id);
            if (! $deleted) {
                return response()->json(['message' => 'Product not found'], JsonResponse::HTTP_NOT_FOUND);
            }

            return response()->json(['message' => 'Product deleted']);
        } catch (Throwable $e) {
            Log::error(
                'ProductController::destroy()',
                [
                    'exception' => $e,
                ]
            );
        }
    }
}
