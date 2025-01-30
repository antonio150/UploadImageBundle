<?php

namespace UploadImageBundle\Controller;

use UploadImageBundle\Service\ImageUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UploadController extends AbstractController
{
    #[Route('/upload', name: 'upload_image', methods: ['POST'])]
    public function upload(Request $request, ImageUploader $imageUploader): Response
    {
        $file = $request->files->get('image');
        if (!$file) {
            return new Response('Aucune image fournie', Response::HTTP_BAD_REQUEST);
        }

        $fileName = $imageUploader->upload($file);
        return new Response('Image uploadée : ' . $fileName);
    }
}
