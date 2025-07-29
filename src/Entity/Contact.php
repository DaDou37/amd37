<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity class representing a contact request submitted via a form.
 *
 * Includes validation constraints to ensure safe and consistent data handling.
 */
#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * First name of the contact sender.
     */
    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "First name is required.")]
    #[Assert\Length(max: 100, maxMessage: "First name cannot exceed 100 characters.")]
    #[Assert\Regex(pattern: "/^[\p{L}\s'-]+$/u", message: "First name must contain only letters.")]
    private ?string $firstName = null;

    /**
     * Last name of the contact sender.
     */
    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Last name is required.")]
    #[Assert\Length(max: 100, maxMessage: "Last name cannot exceed 100 characters.")]
    #[Assert\Regex(pattern: "/^[\p{L}\s'-]+$/u", message: "Last name must contain only letters.")]
    private ?string $lastName = null;

    /**
     * Email address of the contact sender.
     */
    #[ORM\Column(length: 180)]
    #[Assert\NotBlank(message: "Email address is required.")]
    #[Assert\Email(message: "Email address is not valid.")]
    private ?string $email = null;

    /**
     * Subject of the contact message.
     */
    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Subject is required.")]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: "Subject must be at least {{ limit }} characters long.",
        maxMessage: "Subject cannot exceed {{ limit }} characters."
    )]
    private ?string $subject = null;

    /**
     * Message content sent by the user.
     */
    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: "Message content is required.")]
    #[Assert\Length(
        max: 5000,
        min: 10,
        minMessage: "Message must contain at least {{ limit }} characters."
    )]
    private ?string $message = null;

    /**
     * Timestamp of when the contact message was created.
     */
    #[ORM\Column]
    #[Assert\NotNull(message: "Creation date must not be null.")]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * Optional link to the user who submitted the contact form (if logged in).
     */
    #[ORM\ManyToOne(inversedBy: 'contacts')]
    private ?User $user = null;

    // --- Getters & Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        // Ensure email is sanitized before being stored
        $this->email = filter_var($email, \FILTER_SANITIZE_EMAIL);
        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): static
    {
        $this->subject = $subject;
        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;
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
     * Automatically set the creation date when the entity is instantiated.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }
}
