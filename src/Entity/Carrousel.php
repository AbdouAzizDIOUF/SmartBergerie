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
 * @ORM\Entity(repositoryClass="App\Repository\CarrouselRepository")
 */
class Carrousel
{
    const TITLE = [
        '1' => 'edaral',
        '2' => 'eboucher',
        '3' => 'evens',
        '4' => 'offre'
    ];
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

    /**
     * string|null
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $FileName;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="carrousel_image", fileNameProperty="FileName")
     */
    public $ImageFile;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */

    private $CreatedAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $UpdatedAt;

    /**
     * DescriptSite constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->CreatedAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function getTitleType()
    {
        return self::TITLE[$this->Title];
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->FileName;
    }

    public function setFileName($FileName)
    {
        $this->FileName = $FileName;
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
     * @return void
     * @throws Exception
     */
    public function setImageFile(?File $ImageFile = null): void
    {
        $this->ImageFile = $ImageFile;
        if ($this->ImageFile instanceof UploadedFile) {
            $this->UpdatedAt = new DateTime('now');
        }
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->CreatedAt;
    }

    /**
     * @param mixed $CreatedAt
     */
    public function setCreatedAt($CreatedAt): void
    {
        $this->CreatedAt = $CreatedAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->UpdatedAt;
    }

    /**
     * @param mixed $UpdatedAt
     */
    public function setUpdatedAt($UpdatedAt): void
    {
        $this->UpdatedAt = $UpdatedAt;
    }


}
