<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints AS Assert;


/**
 * @UniqueEntity("Title")
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 */
class Event
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Length(min="4", max="255")
     * @ORM\Column(type="string", length=255)
     */
    private $Title;

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

    public function getTitle(): ?string
    {
        return $this->Title;
    }


    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
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
