<?php

namespace App\Entity;

use App\Repository\BannerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass=BannerRepository::class)
 */
class Banner
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\NotBlank(message="Le champ title ne peut pas etre vide")
     * @ORM\Column(type="string", length=255)
     */
    private ?string $title;

    /**
     * @Assert\NotBlank(message="Le champ description ne peut pas etre vide")
     * @ORM\Column(type="string", length=255)
     */
    private ?string $description;

   /**
    * @var File|null
    * @Vich\UploadableField(mapping="banner_image", fileNameProperty="image_name")
    */
    private ?File $imageFile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private ?string $image_name;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private ?\DateTimeImmutable $updated_at;

    /**
     * @Assert\NotBlank(message="Le champ name ne peut pas etre cide")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

   /**
    * @return File|null
    */
    public function getImageFile(): ?File
    {
       return $this->imageFile;
    }

   /**
    * @param File|null $imageFile
    * @return Banner
    */
    public function setImageFile(?File $imageFile = null): self
    {
       $this->imageFile = $imageFile;

       if (null !== $imageFile) {
          $this->updated_at = new \DateTimeImmutable();
       }

       return $this;
    }

    public function getImageName(): ?string
    {
        return $this->image_name;
    }

    public function setImageName(string $image_name = null): self
    {
        $this->image_name = $image_name;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
