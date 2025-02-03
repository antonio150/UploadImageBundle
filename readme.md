# UploadImageBundle

## Introduction

The `UploadImageBundle` is a Symfony bundle that provides an easy way to upload and manage images in your Symfony application.

## Installation

To install the bundle, use Composer:

```bash
composer require antonio150/uploadimagebundle:dev-main
```

## Configuration

Run commande to choose path to store file

```bash
symfony console upload-image-bundle:install
```

Add the bundle to your `config/bundles.php` file:

```php
return [
    // ...
    UploadImageBundle\UploadImageBundle::class => ['all' => true],
];
```

## Usage

To use the bundle, follow these steps:

1. **Edit your `controller` :**

   ```php

        namespace App\Controller;
        use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
        use Symfony\Component\HttpFoundation\Request;
        use Symfony\Component\HttpFoundation\Response;
        use Symfony\Component\Routing\Attribute\Route;
        use UploadImageBundle\Service\FileUploader;

        final class UploadimageController extends AbstractController{

            
            #[Route('/uploadimage', name: 'app_uploadimage')]
            public function upload(Request $request, FileUploader $fileUploader): Response
            {
                $file = $request->files->get('file'); // Récupérer le fichier depuis la requête
                if (!$file) {
                    return $this->json(['error' => 'Aucun fichier envoyé'], Response::HTTP_BAD_REQUEST);
                }

                try {
                    $result = $fileUploader->upload($file);
                    return $this->json($result);
                } catch (\Exception $e) {
                    return $this->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
                }
            }

        }

   ```

## Contact

Portfolio : [antonio navira](https://portfolio-navira.vercel.app/)
