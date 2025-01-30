<?php

namespace App\UploadImageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

class UploadType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('image', FileType::class, [
                'label' => 'Upload Image',
                'mapped' => false,
                'attr' => [
                    'accept' => 'image/png, image/gif, image/jpeg', // ✅ Ajoute l'attribut accept
                ],
                'required' => true, // Assure-toi qu'un fichier est téléchargé
                
            ]);
    }
}
