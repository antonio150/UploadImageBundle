<?php

namespace UploadImageBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageUploader
{
    private string $uploadDir;
    private string $publicPath;

    public function __construct(string $uploadDir, string $publicPath)
    {
        $this->uploadDir = $uploadDir;
        $this->publicPath = $publicPath;
    }

    public function upload(UploadedFile $file): array
    {
        $fileName = uniqid() . '.' . $file->guessExtension();
        $file->move($this->uploadDir, $fileName);

        return [
            'fileName' => $fileName,
            'absolutePath' => $this->uploadDir . '/' . $fileName,
            'publicPath' => $this->publicPath . '/' . $fileName
        ];
    }
}
