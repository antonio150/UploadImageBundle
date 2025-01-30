<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
#[ORM\Table(name: "image_uploads")]
class ImageUpload
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    private ?string $filename = null;

    #[ORM\Column(type: "datetime")]
    private \DateTimeInterface $uploadedAt;

    #[Assert\File(mimeTypes: ['image/jpeg', 'image/png'])]
    private ?File $image = null;

    public function __construct()
    {
        $this->uploadedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function getUploadedAt(): \DateTimeInterface
    {
        return $this->uploadedAt;
    }

    public function setUploadedAt(\DateTimeInterface $uploadedAt): self
    {
        $this->uploadedAt = $uploadedAt;
        return $this;
    }

    // Getter et setter pour la propriété image
    public function getImage(): ?File
    {
        return $this->image;
    }

    public function setImage(?File $image = null): void
    {
        $this->image = $image;

        // Optionnellement, tu peux déclencher la mise à jour de la date de modification
        if ($image) {
            // Si tu veux gérer une date de mise à jour, tu peux définir une propriété `updatedAt`
            $this->uploadedAt = new \DateTime();
        }
    }
}
