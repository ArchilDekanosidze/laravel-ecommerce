<?php

namespace App\Services\Uploader;


use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StorageManager
{
    protected $file;
    protected $convertedFile;
    protected $exclusiveDirectory;
    protected $fileDirectory;
    protected $fileName;
    protected $fileFormat;
    protected $finalFileDirectory;
    protected $finalFileName;
    protected $disk = 'public';

    public function putFile()
    {
        return Storage::disk($this->disk)->put($this->getFileAddress(), $this->convertedFile);
    }

    public function isFileExists(string $fileName)
    {
        return Storage::disk($this->disk)->exists($fileName);
    }

    public function getFile(string $fileName)
    {
        return Storage::disk($this->disk)->download($fileName);
    }


    public function deleteFile(string $fileName)
    {
        return  Storage::disk($this->disk)->delete($fileName);
    }

    public function deleteDirectory(string $dirName)
    {
        return  Storage::disk($this->disk)->deleteDirectory($dirName);
    }


    public function setFile($file)
    {
        $this->file = $file;
        $this->provider();
    }

    public function setConvertedFile($convertedFile)
    {
        $this->convertedFile = $convertedFile;
    }

    public function getExclusiveDirectory()
    {
        return $this->exclusiveDirectory;
    }

    public function setExclusiveDirectory($exclusiveDirectory)
    {
        $this->exclusiveDirectory = trim($exclusiveDirectory, '/\\');
    }

    public function getFileDirectory()
    {
        return $this->fileDirectory;
    }
    public function setFileDirectory($fileDirectory)
    {
        $this->fileDirectory = trim($fileDirectory, '/\\');
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function setCurrentFileName()
    {
        return !empty($this->file) ? $this->setFileName(pathinfo($this->file->getClientOriginalName(), PATHINFO_FILENAME)) : false;
    }

    public function getFileFormat()
    {
        return $this->fileFormat;
    }

    public function setFileFormat($fileFormat)
    {
        $this->fileFormat = $fileFormat;
    }

    public function getFinalFileDirectory()
    {
        return $this->finalFileDirectory;
    }

    public function setFinalFileDirectory($finalFileDirectory)
    {
        $this->finalFileDirectory = $finalFileDirectory;
    }

    public function getFinalFileName()
    {
        return $this->finalFileName;
    }

    public function setFinalFileName($finalFileName)
    {
        $this->finalFileName = $finalFileName;
    }

    protected function checkDirectory($fileDirectory)
    {
        if (!$this->isFileExists($fileDirectory)) {
            Storage::disk($this->disk)->makeDirectory($fileDirectory, 0777);
        }
    }

    public function getFileAddress()
    {
        return $this->finalFileDirectory . DIRECTORY_SEPARATOR . $this->finalFileName;
    }

    public function setDisk($disk)
    {
        $this->disk = $disk;
    }

    public function getDisk()
    {
        return $this->disk;
    }

    public function provider()
    {
        //set properties
        $this->getFileDirectory() ?? $this->setFileDirectory(date('Y') . DIRECTORY_SEPARATOR . date('m') . DIRECTORY_SEPARATOR . date('d') . DIRECTORY_SEPARATOR . time());
        $this->getFileName() ?? $this->setFileName(time());
        $this->getFileFormat() ?? $this->setFileFormat($this->file->extension());

        //set final file Directory
        $finalFileDirectory = empty($this->getExclusiveDirectory()) ? $this->getFileDirectory() : $this->getExclusiveDirectory() . DIRECTORY_SEPARATOR . $this->getFileDirectory();
        $this->setFinalFileDirectory($finalFileDirectory);

        //set final file name
        $this->setFinalFileName($this->getFileName() . '.' . $this->getFileFormat());


        //check adn create final file directory
        $this->checkDirectory($this->getFinalFileDirectory());
    }
}
