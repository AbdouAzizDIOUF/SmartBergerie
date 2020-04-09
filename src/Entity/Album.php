<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Vich\Uploadable
 * @ORM\Entity(repositoryClass="App\Repository\AlbumRepository")
 */
class Album
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ImageName;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="album_image", fileNameProperty="ImageName")
     */
    public $ImageFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="datetime")
     */
    private $UpdatedAt;


    /**
     * Album constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->CreatedAt = new DateTime();
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->ImageFile;
    }

    /**
     * @param File|null $ImageFile
     */
    public function setImageFile(?File $ImageFile): void
    {
        $this->ImageFile = $ImageFile;
        if ($this->ImageFile instanceof UploadedFile) {
            $this->UpdatedAt = new DateTime('now');
        }
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageName(): ?string
    {
        return $this->ImageName;
    }

    public function setImageName($ImageName)
    {
        $this->ImageName = $ImageName;

    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

}
