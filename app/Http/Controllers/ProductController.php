<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
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

        $images = $data['images'];
        unset($data['images']);

        $product = DB::transaction(function () use ($data, $images) {

            $product = Product::create($data);

            foreach ($images as $index => $image) {

                $sortOrder = $index + 1;

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

    }
}
