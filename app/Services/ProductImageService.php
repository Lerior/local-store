<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Format;

class ProductImageService {

    protected ImageManager $manager;

    public function __construct()
    {
        $this->manager = new ImageManager( new Driver() );
    }

    public function store(
        UploadedFile $file,
        int $productId,
        int $sortOrder
    ): string {
        
        $image = $this->manager->decode($file);

        $encoded = $image->encodeUsingFormat(Format::WEBP);

        $path = "products/{$productId}/{$sortOrder}/large.webp";

        Storage::disk('public')->put($path, $encoded);

        return $path;

    }

}