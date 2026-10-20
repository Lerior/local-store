<?php

namespace App\Services;

use Exception;
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
        $pathComplement = "products/{$productId}/{$sortOrder}/";
        $images = $this->redimensionImage($file, $pathComplement);

        foreach ($images['path'] as $index => $path) {
            $encoded = $images['encoded'][$index];

            $stored = Storage::disk('public')->put($path, $encoded);

            if (! $stored) {
                throw new Exception("Couldn't store the image");
            }

        }

        return "products/{$productId}/{$sortOrder}/";
    }

    public function updateImages(
        UploadedFile $file,
        int $productId,
        int $sortOrder,
    ): string {
        $tempOrder = bin2hex(random_bytes(8));
        $pathComplement = "products/temp/{$tempOrder}/";

        try {

            $images = $this->redimensionImage($file, $pathComplement);
            $disk = Storage::disk('public');

            foreach ($images['path'] as $index => $path) {
                $encoded = $images['encoded'][$index];

                $stored = $disk->put($path, $encoded);

                if (! $stored) {
                    throw new Exception("Couldn't store the image");
                }
            }

            foreach ($images['path'] as $index => $path) {
                $formats = ['large.webp', 'medium.webp', 'thumbnail.webp'];

                $newPath = "products/{$productId}/{$sortOrder}/{$formats[$index]}";

                if ($disk->exists($newPath)) {

                    $deleted = $disk->delete($newPath);

                    if (!$deleted) {
                        throw new Exception("Couldn't delete the old image");
                    }
                }

                $moved = $disk->move($path, $newPath);

                if (! $moved) {
                    throw new Exception("Couldn't move the image");
                }
            }

            return "products/{$productId}/{$sortOrder}/";

        } finally {

            $this->deleteTempPath($tempOrder);
        }
    }

    private function redimensionImage(
        UploadedFile $file,
        string $pathComplement
    ): array {

        $image = $this->manager->decode($file);

        $formats = [
            ['dimension' => 1920, 'name' => 'large.webp'],
            ['dimension' => 600, 'name' => 'medium.webp'],
            ['dimension' => 150, 'name' => 'thumbnail.webp'],
        ];

        $images = [];
        foreach ($formats as $format) {

            $resizedImage = clone $image;

            $resizedImage->scaleDown(
                width: $format['dimension'],
                height: $format['dimension']
            );

            $encoded = $resizedImage->encodeUsingFormat(Format::WEBP);

            $path = $pathComplement."{$format['name']}";

            $images['path'][] = $path;
            $images['encoded'][] = $encoded;
        }

        return $images;
    }

    public function deletePath(int $productId)
    {
        $path = "products/{$productId}";

        Storage::disk('public')->deleteDirectory($path);
    }

    public function deleteTempPath(string $tempOrder)
    {
        $path = "products/temp/{$tempOrder}";

        Storage::disk('public')->deleteDirectory($path);
    }
}
