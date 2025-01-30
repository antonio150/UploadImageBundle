<?php

namespace App\UploadImageBundle\Controller;

use App\Entity\ImageUpload;
use App\UploadBundle\Entity\Image;
use App\UploadBundle\Form\ImageType;
use App\UploadImageBundle\Form\UploadType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class UploadController extends AbstractController
{
    #[Route('/upload', name: 'image_upload')]
    public function upload(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        $image = new ImageUpload();
        $form = $this->createForm(UploadType::class, $image);
        $form->handleRequest($request);

        
        // Si le formulaire est soumis et valide
        if ($form->isSubmitted() ) {
            $file = $form->get('image')->getData();
            // dd("erere");
            // Vérifie si un fichier est bien présent
            if ($file) {
                $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

                // Déplace le fichier dans le répertoire souhaité
                $file->move($this->getParameter('upload_directory'), $newFilename);

                // Enregistre le nom du fichier dans la base de données
                $image->setFilename($newFilename);
                $em->persist($image);
                $em->flush();

                $this->addFlash('success', 'Image uploaded successfully!');
                return $this->redirectToRoute('image_upload');
            } else {
                // Si le fichier n'est pas présent, tu peux ajouter un message d'erreur personnalisé
                $this->addFlash('error', 'No file was uploaded.');
            }
        } else {
            // Affiche les erreurs si le formulaire n'est pas valide
            dump($form->getErrors(true));
        }

        return $this->render('@UploadImage/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
