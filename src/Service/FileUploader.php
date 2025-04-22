<?php

namespace UploadImageBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private string $documentsDir;
    private string $videosDir;
    private string $imagesDir;
    private ParameterBagInterface $params;
    private Filesystem $filesystem;

    public function __construct(ParameterBagInterface $params, Filesystem $filesystem)
    {
        $this->documentsDir = $params->get('upload_image_bundle.documents_dir');
        $this->videosDir = $params->get('upload_image_bundle.videos_dir');
        $this->imagesDir = $params->get('upload_image_bundle.images_dir');
        $this->filesystem = $filesystem;
        $this->params = $params;
    }

    public function upload( UploadedFile $file): array
    {
        // Détection automatique du type en fonction du MIME type
        $mimeType = $file->getMimeType();
        $targetDir = $this->getTargetDirectory($mimeType);

        // Générer un nom unique
        $fileName = uniqid() . '.' . $file->guessExtension();

        // Déplacer le fichier vers le bon répertoire
        $file->move($targetDir, $fileName);

        // Calculer le chemin relatif pour public_path
        $projectDir = realpath($this->params->get('kernel.project_dir') . '/public');
        $absoluteTargetDir = realpath($targetDir);
        $relativePath = str_replace($projectDir, '', $absoluteTargetDir) . '/' . $fileName;
        $publicPath = str_replace('\\', '/', $relativePath);

        return [
            'fileName' => $fileName,
            'absolute_path' => realpath($targetDir . '/' . $fileName),
            'public_path' => $publicPath
        ];
    }

    private function getTargetDirectory(string $mimeType): string
    {
        return match (true) {
            str_starts_with($mimeType, 'image/') => $this->imagesDir,
            str_starts_with($mimeType, 'video/') => $this->videosDir,
            str_starts_with($mimeType, 'application/') || str_starts_with($mimeType, 'text/') => $this->documentsDir,
            default => throw new \InvalidArgumentException('Type de fichier non supporté : ' . $mimeType),
        };
    }
}
