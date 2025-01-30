<?php

namespace App\UploadImageBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ImageUploader
{
    private string $uploadDir;
    private Filesystem $filesystem;

    public function __construct(ParameterBagInterface $params)
    {
        $this->uploadDir = $params->get('upload_directory');
        $this->filesystem = new Filesystem();
    }

    public function upload(UploadedFile $file): string
    {
        $filename = uniqid().'.'.$file->guessExtension();
        $file->move($this->uploadDir, $filename);
        return $filename;
    }

    public function delete(string $filename): void
    {
        $filePath = $this->uploadDir . '/' . $filename;
        if ($this->filesystem->exists($filePath)) {
            $this->filesystem->remove($filePath);
        }
    }
}
