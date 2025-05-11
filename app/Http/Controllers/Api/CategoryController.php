<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoriesRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class CategoryController extends Controller
{
    public function __construct(
        protected CategoriesRepositoryInterface $categoriesRepositoryInterface
    ) {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        try {
            return $this->categoriesRepositoryInterface->getAll();
        } catch (Throwable $e) {
            Log::error(
                'CategoryController::store()',
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
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $category = $this->categoriesRepositoryInterface->create($validated);

            return response()->json([
                'message' => 'Successfully created category',
                'category' => $category,
            ], JsonResponse::HTTP_CREATED);
        } catch (Throwable $e) {
            Log::error(
                'CategoryController::store()',
                [
                    'exception' => $e,
                ]
            );
        }
    }

    public function show(int $id)
    {
        try {
            $category = $this->categoriesRepositoryInterface->getById($id);

            if (! $category) {
                return response()->json(['message' => 'Category not found'], JsonResponse::HTTP_NOT_FOUND);
            }

            return $category;
        } catch (Throwable $e) {
            Log::error(
                'CategoryController::show()',
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
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $category = $this->categoriesRepositoryInterface->update($id, $validated);

            if (! $category) {
                return response()->json(['message' => 'Category not found'], JsonResponse::HTTP_NOT_FOUND);
            }

            return response()->json([
                'message' => 'Category updated successfully',
                'category' => $category,
            ], JsonResponse::HTTP_OK);
        } catch (Throwable $e) {
            Log::error(
                'CategoryController::update()',
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

            $deleted = $this->categoriesRepositoryInterface->delete($id);

            if (! $category) {
                return response()->json(['message' => 'Category not found'], JsonResponse::HTTP_NOT_FOUND);
            }

            return response()->json(['message' => 'Category deleted successfully'], JsonResponse::HTTP_OK);
        } catch (Throwable $e) {
            Log::error(
                'CategoryController::destroy()',
                [
                    'exception' => $e,
                ]
            );
        }
    }
}
