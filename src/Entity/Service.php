<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a service provided by the user or company.
 * Each service has a title, description, image, and metadata.
 */
#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Title of the service.
     */
    #[ORM\Column(length: 100)]
    private ?string $title = null;

    /**
     * Optional detailed description of the service.
     */
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * Optional position to define display order.
     */
    #[ORM\Column(nullable: true)]
    private ?int $position = null;

    /**
     * Creation timestamp of the service entry.
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * Optional image path for service preview.
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    /**
     * Optional icon filename used in UI.
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $iconFilename = null;

    /**
     * The user who created or owns this service.
     */
    #[ORM\ManyToOne(inversedBy: 'services')]
    private ?User $user = null;

    /**
     * URL-friendly version of the service title.
     */
    #[ORM\Column(length: 150)]
    private ?string $slug = null;

    // --- Getters & Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(?int $position): static
    {
        $this->position = $position;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;
        return $this;
    }

    public function getIconFilename(): ?string
    {
        return $this->iconFilename;
    }

    public function setIconFilename(?string $iconFilename): static
    {
        $this->iconFilename = $iconFilename;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }
}
