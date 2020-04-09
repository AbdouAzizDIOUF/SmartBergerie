<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Component\Validator\Constraints AS Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DescriptSiteRepository")
 */
class DescriptSite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(min="255")
     * @ORM\Column(type="text")
     */
    private $Contenu;

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

    public function getContenu(): ?string
    {
        return $this->Contenu;
    }

    public function setContenu(string $Contenu): self
    {
        $this->Contenu = $Contenu;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }
}
