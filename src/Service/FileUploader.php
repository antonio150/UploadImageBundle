<?php

namespace UploadImageBundle\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private string $documentsDir;
    private string $videosDir;
    private string $imagesDir;

    public function __construct(string $documentsDir, string $videosDir, string $imagesDir)
    {
        $this->documentsDir = $documentsDir;
        $this->videosDir = $videosDir;
        $this->imagesDir = $imagesDir;
    }

    public function upload(UploadedFile $file): array
    {
        $extension = strtolower($file->guessExtension());
        $fileName = uniqid() . '.' . $extension;

        // Vérification du type de fichier pour choisir le bon dossier
        if (in_array($extension, ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'csv'])) {
            $uploadDir = $this->documentsDir;
        } elseif (in_array($extension, ['mp4', 'avi', 'mov', 'mkv'])) {
            $uploadDir = $this->videosDir;
        } elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            $uploadDir = $this->imagesDir;
        } else {
            throw new \Exception("Type de fichier non pris en charge !");
        }

        // Créer le dossier s'il n'existe pas
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $file->move($uploadDir, $fileName);

        return [
            'fileName' => $fileName,
            'absolutePath' => $uploadDir . '/' . $fileName
        ];
    }
}
