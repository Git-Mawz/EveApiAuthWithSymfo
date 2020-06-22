<?php

namespace App\Entity;

use App\Repository\CapsulerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CapsulerRepository::class)
 */
class Capsuler
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
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $eveCharacterId;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $characterOwnerHash;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEveCharacterId(): ?int
    {
        return $this->eveCharacterId;
    }

    public function setEveCharacterId(int $eveCharacterId): self
    {
        $this->eveCharacterId = $eveCharacterId;

        return $this;
    }

    public function getCharacterOwnerHash(): ?string
    {
        return $this->characterOwnerHash;
    }

    public function setCharacterOwnerHash(string $characterOwnerHash): self
    {
        $this->characterOwnerHash = $characterOwnerHash;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
