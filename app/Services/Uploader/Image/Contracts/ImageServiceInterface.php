<?php

namespace App\Services\Uploader\Image\Contracts;

use App\Services\Uploader\StorageManager;

interface ImageServiceInterface
{
    public function __construct(StorageManager $storageManager);
    public function save($image);
    public function fitAndSave($image, $width, $height);

    public function createIndexAndSave($image);

    public function deleteFiles($indexArray);

    public function setExclusiveDirectory($exclusiveDirectory);
    public function setDisk($disk);
}
