<?php

namespace App\Entity;

use App\Repository\TestimonialRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Represents a testimonial left by a user or visitor.
 * Can optionally be linked to a user account.
 */
#[ORM\Entity(repositoryClass: TestimonialRepository::class)]
class Testimonial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * Author name of the testimonial.
     */
    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le nom est obligatoire')]
    #[Assert\Length(
        max: 100,
        maxMessage: 'Le nom ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $author = null;

    /**
     * Main content/message of the testimonial.
     */
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Le message est obligatoire')]
    #[Assert\Length(
        min: 5,
        max: 2000,
        minMessage: 'Le message doit contenir au moins {{ limit }} caractères',
        maxMessage: 'Le message ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $content = null;

    /**
     * Date and time when the testimonial was created.
     */
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * Whether the testimonial has been approved for public display.
     */
    #[ORM\Column(type: 'boolean')]
    private bool $isApproved = false;

    #[ORM\Column(length: 100, nullable: true)]
    #[Assert\NotBlank(message: 'Le prénom est obligatoire')]
    #[Assert\Length(max: 100, maxMessage: 'Le prénom ne peut pas dépasser {{ limit }} caractères')]
    private ?string $firstName = null; // Nouveau champ prénom

    /**
     * Optional subject or title of the testimonial.
     */
    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Le sujet ne peut pas dépasser {{ limit }} caractères'
    )]
    private ?string $subject = null;

    /**
     * Optional relation to the user entity (if the testimonial is from a registered user).
     */
    #[ORM\ManyToOne(inversedBy: 'testimonials')]
    private ?User $user = null;

    /**
     * Constructor to auto-set creation date.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    // --- Getters & Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
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

    public function isApproved(): bool
    {
        return $this->isApproved;
    }

    public function setIsApproved(bool $isApproved): static
    {
        $this->isApproved = $isApproved;
        return $this;
    }

    public function getFirstName(): ?string 
    {
        return $this->firstName; 
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName; return $this; 
    }


    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): static
    {
        $this->subject = $subject;
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

    /**
     * Used for representing this entity as a string (e.g. in dropdowns).
     */
    public function __toString(): string
    {
        return $this->author;
    }
}
