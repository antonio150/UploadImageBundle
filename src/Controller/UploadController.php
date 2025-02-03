<?php

namespace UploadImageBundle\Controller;

use UploadImageBundle\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use UploadImageBundle\Service\FileUploader;

class UploadController extends AbstractController
{
    #[Route('/upload', name: 'upload_image', methods: ['POST'])]
    public function upload(Request $request, FileUploader $fileUploader): Response
    {
        $file = $request->files->get('image');
        if (!$file) {
            return new Response('Aucune fichier fournie', Response::HTTP_BAD_REQUEST);
        }

        $fileName = $fileUploader->upload($file);
        return new Response('fichier uploadée : ' . $fileName);
    }
}
