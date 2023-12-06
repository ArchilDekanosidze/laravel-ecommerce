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
        $fileFormat = $this->prepareStorage($image);
        $convertedImage = Image::make($image->getRealPath())->encode($fileFormat);
        return $this->storeAndGetAddress($convertedImage);
    }


    public function fitAndSave($image, $width, $height)
    {
        $fileFormat = $this->prepareStorage($image);

        $convertedImage = Image::make($image->getRealPath())->fit($width, $height)->encode($fileFormat);

        return $this->storeAndGetAddress($convertedImage);
    }

    public function createIndexAndSave($image)
    {
        $imageSizes = Config::get('image.index-image-sizes');

        $fileFormat = $this->prepareStorage($image);

        $imageName = $this->storageManager->getFileName();


        $indexArray = [];
        foreach ($imageSizes as $sizeAlias => $imageSize) {

            $currentImageName = $imageName . '_' . $sizeAlias;
            $this->storageManager->setFileName($currentImageName);

            $this->storageManager->provider();

            $convertedImage = Image::make($image->getRealPath())->fit($imageSize['width'], $imageSize['height'])->encode($fileFormat);

            $indexArray[$sizeAlias] = $this->storeAndGetAddress($convertedImage);
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

    public function prepareStorage($image)
    {
        $this->storageManager->setFile($image);
        return $this->storageManager->getFileFormat();
    }

    public function storeAndGetAddress($convertedImage)
    {
        $this->storageManager->setConvertedFile($convertedImage);
        $this->storageManager->putFile();
        return $this->storageManager->getFileAddress();
    }
}
