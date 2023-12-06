<?php

namespace App\Services\Uploader\Image;


use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Config;
use App\Services\Uploader\StorageManager;
use App\Services\Uploader\Image\Contracts\ImageServiceInterface;

class ImageInterventionService implements ImageServiceInterface
{
    private $storageManager;
    public function __construct(StorageManager $storageManager)
    {
        $this->storageManager = $storageManager;
    }

    public function save($image)
    {
        $this->storageManager->setFile($image);

        $newImage = Image::make($image->getRealPath())->encode('jpg');
        $this->storageManager->setNewFile($newImage);

        $this->storageManager->putFile();
        return $this->storageManager->getFileAddress();
    }


    public function fitAndSave($image, $width, $height)
    {
        $this->storageManager->setFile($image);

        $newImage = Image::make($image->getRealPath())->fit($width, $height)->encode('jpg');
        $this->storageManager->setNewFile($newImage);

        $this->storageManager->putFile();
        return $this->storageManager->getFileAddress();
    }

    public function createIndexAndSave($image)
    {
        $imageSizes = Config::get('image.index-image-sizes');

        $this->storageManager->setFile($image);

        $imageName = $this->storageManager->getFileName();


        $indexArray = [];
        foreach ($imageSizes as $sizeAlias => $imageSize) {

            $currentImageName = $imageName . '_' . $sizeAlias;
            $this->storageManager->setFileName($currentImageName);

            $this->storageManager->provider();

            $newImage = Image::make($image->getRealPath())->fit($imageSize['width'], $imageSize['height'])->encode('jpg');
            $this->storageManager->setNewFile($newImage);
            $this->storageManager->putFile();
            $indexArray[$sizeAlias] = $this->storageManager->getFileAddress();
        }
        $images['indexArray'] = $indexArray;
        $images['currentImage'] = Config::get('image.default-current-index-image');

        return $images;
    }

    public function deleteFiles($indexArray)
    {
        foreach ($indexArray as $file) {
            $this->storageManager->deleteFile($file);
        }
        $this->storageManager->deleteDirectory(dirname($file));
    }

    public function setExclusiveDirectory($exclusiveDirectory)
    {
        $this->storageManager->setExclusiveDirectory($exclusiveDirectory);
    }

    public function setDisk($disk)
    {
        $this->storageManager->setDisk($disk);
    }
}
