<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class Contact
{
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    #[Assert\Length(max: 100, maxMessage: "Le prénom ne doit pas dépasser 100 caractères.")]
    #[Assert\Regex(pattern: "/^[\p{L}\s'-]+$/u", message: "Le prénom doit comporter uniquement des lettres.")]
    private ?string $firstName = null;

    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(max: 100, maxMessage: "Le nom ne doit pas dépasser 100 caractères.")]
    #[Assert\Regex(pattern: "/^[\p{L}\s'-]+$/u", message: "Le nom doit comporter uniquement des lettres.")]
    private ?string $lastName = null;

    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(message: "L'email n'est pas valide.")]
    private ?string $email = null;

    #[Assert\NotBlank(message: "Le sujet est obligatoire.")]
    #[Assert\Length(
        min: 5,
        max: 255,
        minMessage: "Le sujet doit faire au moins {{ limit }} caractères.",
        maxMessage: "Le sujet ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $subject = null;

    #[Assert\NotBlank(message: "Le message est obligatoire.")]
    #[Assert\Length(
        min: 10,
        max: 5000,
        minMessage: "Le message doit faire au moins {{ limit }} caractères."
    )]
    private ?string $message = null;

    private ?string $captcha = null;

    // --- Getters ---
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getCaptcha(): ?string
    {
        return $this->captcha;
    }

    // --- Setters (optionnel mais pratique pour Symfony Forms) ---
    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function setSubject(?string $subject): static
    {
        $this->subject = $subject;
        return $this;
    }

    public function setMessage(?string $message): static
    {
        $this->message = $message;
        return $this;
    }

    public function setCaptcha(?string $captcha): static
    {
        $this->captcha = $captcha;
        return $this;
    }
}
