<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProjectRepository;
use Symfony\Component\String\Slugger\AsciiSlugger;

/**
 * Entity class representing a user project.
 *
 * Each project is associated with a user, a type, a category, and includes
 * metadata such as title, description, image, timestamps, and online status.
 */
#[ORM\Entity(repositoryClass: ProjectRepository::class)]
class Project
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Project title.
     */
    #[ORM\Column(length: 255)]
    private ?string $title = null;

    /**
     * Detailed description of the project.
     */
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * Date and time when the project was created.
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * Optional project cover image (filename or URL).
     */
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    /**
     * The user who owns or created the project.
     */
    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * The type/category of the project (e.g., website, application).
     */
    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProjectType $type = null;

    /**
     * URL-friendly version of the title.
     */
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * Last time the project was updated (optional).
     */
    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * Whether the project is visible/online.
     */
    #[ORM\Column]
    private ?bool $isOnline = null;

    /**
     * Project classification or broader category.
     */
    #[ORM\ManyToOne(inversedBy: 'projects')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ProjectCategory $projectCategory = null;

    /**
     * Automatically sets creation date and default online status.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->isOnline = false;
    }

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

    public function setDescription(string $description): static
    {
        $this->description = $description;
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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function isOnline(): ?bool
    {
        return $this->isOnline;
    }

    public function setIsOnline(bool $isOnline): static
    {
        $this->isOnline = $isOnline;
        return $this;
    }

    public function getType(): ?ProjectType
    {
        return $this->type;
    }

    public function setType(?ProjectType $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getProjectCategory(): ?ProjectCategory
    {
        return $this->projectCategory;
    }

    public function setProjectCategory(?ProjectCategory $projectCategory): static
    {
        $this->projectCategory = $projectCategory;
        return $this;
    }
}
