# UploadImageBundle

## Introduction

The `UploadImageBundle` is a Symfony bundle that provides an easy way to upload and manage images in your Symfony application.

## Installation

To install the bundle, use Composer:

```bash
composer require antonio150/uploadimagebundle:dev-main
```

## Configuration

Add the bundle to your `config/bundles.php` file:

```php
return [
    // ...
    UploadImageBundle\UploadImageBundle::class => ['all' => true],
];
```

Add to composer.json:

```json
"repositories": [
    {
    "type": "vcs",
    "url": "https://github.com/antonio150/UploadImageBundle.git"
    }
],
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
    use UploadImageBundle\Service\ImageUploader;

    final class UploadimageController extends AbstractController{

        private ImageUploader $uploadService; // ajouter

        public function __construct(ImageUploader $uploadService) // ajouter
        {
            $this->uploadService = $uploadService;
        }
        #[Route('/uploadimage', name: 'app_uploadimage')]
        public function index(Request $request): Response
        {
            $file = $request->files->get('image');

            if ($file) {
                $uploadResult = $this->uploadService->upload($file); // La façon de l'utiliser

                return $this->json([
                    'message' => 'Image uploadée avec succès',
                    'fileName' => $uploadResult['fileName'],
                    'absolutePath' => $uploadResult['absolutePath'],
                    'publicUrl' => $request->getSchemeAndHttpHost() . $uploadResult['publicPath'],
                ]); // exemple de sortie
            }

            return new Response("Aucune image envoyée.");
        }

    }

    ```

## License

This bundle is released under the MIT License. See the bundled `LICENSE` file for details.
