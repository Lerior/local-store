<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Format;
use Intervention\Image\ImageManager;

class ProductImageService
{
    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver);
    }

    public function store(
        UploadedFile $file,
        int $productId,
        int $sortOrder
    ): string {
        $image = $this->manager->decode($file);

        $formats = [
            ['dimension' => 1920, 'name' => 'large.webp'],
            ['dimension' => 600, 'name' => 'medium.webp'],
            ['dimension' => 150, 'name' => 'thumbnail.webp'],
        ];

        foreach ($formats as $format) {

            $resizedImage = clone $image;

            $resizedImage->scaleDown(
                width: $format['dimension'],
                height: $format['dimension']
            );

            $encoded = $resizedImage->encodeUsingFormat(Format::WEBP);

            $path = "products/{$productId}/{$sortOrder}/{$format['name']}";

            Storage::disk('public')->put($path, $encoded);

        }

        return "products/{$productId}/{$sortOrder}/";
    }

    public function deletePath(int $productId)
    {

        $path = "products/{$productId}";

        Storage::disk('public')->deleteDirectory($path);

    }

    public function updateImages(
        UploadedFile $file,
        int $productId,
        int $sortOrder,
    ): string {
        return $this->store($file, $productId, $sortOrder);
    }
}
