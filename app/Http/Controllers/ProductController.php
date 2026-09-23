<?php

namespace App\Http\Controllers;

use App\Http\Requests\FiltersProductRequest;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\Services\ProductImageService;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function __construct(
        protected ProductImageService $imageService
    ) {}

    public function addProduct(ProductStoreRequest $request)
    {

        $data = $request->validated();
        $productId = null;

        $images = $data['images'];
        unset($data['images']);

        try {
            $product = DB::transaction(function () use ($data, $images, &$productId) {

                $product = Product::create($data);
                $productId = $product->id;

                foreach ($images as $sortOrder => $image) {

                    $path = $this->imageService->store(
                        $image,
                        $product->id,
                        $sortOrder
                    );

                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $path,
                        'sort_order' => $sortOrder,
                    ]);
                }

                return $product;

            });

            $product->load('images');

            return response()->json([
                'message' => 'Product created successfully',
                'product' => $product,
            ], 201);
        } catch (\Throwable $e) {

            report($e);

            if ($productId !== null) {
                $this->imageService->deletePath($productId);
            }

            return response()->json([
                'message' => 'Error al crear producto',
            ], 500);
        }
    }

    public function getProducts(FiltersProductRequest $request)
    {

        $data = $request->validated();

        $perPage = $data['per_page'] ?? 10;
        $orderBy = $data['order_by'] ?? 'created_at';
        $order = $data['order'] ?? 'desc';

        return
        Product::with('images')
            ->when(
                isset($data['search']),
                fn ($query) => $query->search($data['search'])
            )
            ->orderBy($orderBy, $order)
            ->paginate($perPage);
    }

    public function getProductById(int $id)
    {

        $product = Product::with('images')->find($id);

        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function updateProductById(ProductUpdateRequest $request, int $id)
    {

        $product = Product::find($id);

        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $data = $request->validated();

        $images = $data['images'] ?? null;
        unset($data['images']);

        try {
            DB::transaction(function () use ($product, $data, $images) {

                $product->update($data);

                if ($images !== null) {
                    foreach ($images as $sortOrder => $image) {
                        $path = $this->imageService->updateImages(
                            $image,
                            $product->id,
                            (int) $sortOrder
                        );

                        ProductImage::updateOrCreate(
                            [
                                'product_id' => $product->id,
                                'sort_order' => (int) $sortOrder,
                            ],
                            [
                                'path' => $path,
                            ]
                        );
                    }
                }
            });

            $product->load('images');

            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product,
            ], 200);

        } catch (\Throwable $e) {

            report($e);

            return response()->json([
                'message' => 'Error at product update',
            ], 500);
        }
    }

    public function deleteProductById(int $id)
    {

        $product = Product::find($id);

        if (! $product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();
        $this->imageService->deletePath($id);

        return response()->json(['message' => 'Product deleted'], 200);
    }
}
