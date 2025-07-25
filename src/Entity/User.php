<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $firstname = null;

    #[ORM\Column(length: 100)]
    private ?string $lastname = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    private ?string $role = 'ROLE_USER';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTime $updatedAt = null;

    #[ORM\OneToMany(targetEntity: Project::class, mappedBy: 'user')]
    private Collection $projects;

    #[ORM\OneToMany(targetEntity: Testimonial::class, mappedBy: 'user')]
    private Collection $testimonials;

    #[ORM\OneToMany(targetEntity: Gallery::class, mappedBy: 'user')]
    private Collection $galleries;

    #[ORM\OneToMany(targetEntity: Service::class, mappedBy: 'user')]
    private Collection $services;

    #[ORM\OneToMany(targetEntity: Contact::class, mappedBy: 'user')]
    private Collection $contacts;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
        $this->testimonials = new ArrayCollection();
        $this->galleries = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;
        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): static
    {
        $this->role = $role;
        return $this;
    }

    public function getRoles(): array
    {
        return [$this->role ?? 'ROLE_USER'];
    }

    public function getUserIdentifier(): string
    {
        return $this->email ?? '';
    }

    public function eraseCredentials(): void
    {
        // Rien à nettoyer ici
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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTime $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function __toString(): string
    {
        return $this->email; // ou firstName . ' ' . lastName, selon ce que tu veux afficher
    }

    // Relations setters/getters (pas modifiés ici)

    public function getProjects(): Collection { return $this->projects; }
    public function addProject(Project $project): static {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setUser($this);
        }
        return $this;
    }
    public function removeProject(Project $project): static {
        if ($this->projects->removeElement($project) && $project->getUser() === $this) {
            $project->setUser(null);
        }
        return $this;
    }

    public function getTestimonials(): Collection { return $this->testimonials; }
    public function addTestimonial(Testimonial $testimonial): static {
        if (!$this->testimonials->contains($testimonial)) {
            $this->testimonials->add($testimonial);
            $testimonial->setUser($this);
        }
        return $this;
    }
    public function removeTestimonial(Testimonial $testimonial): static {
        if ($this->testimonials->removeElement($testimonial) && $testimonial->getUser() === $this) {
            $testimonial->setUser(null);
        }
        return $this;
    }

    public function getGalleries(): Collection { return $this->galleries; }
    public function addGallery(Gallery $gallery): static {
        if (!$this->galleries->contains($gallery)) {
            $this->galleries->add($gallery);
            $gallery->setUser($this);
        }
        return $this;
    }
    public function removeGallery(Gallery $gallery): static {
        if ($this->galleries->removeElement($gallery) && $gallery->getUser() === $this) {
            $gallery->setUser(null);
        }
        return $this;
    }

    public function getServices(): Collection { return $this->services; }
    public function addService(Service $service): static {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setUser($this);
        }
        return $this;
    }
    public function removeService(Service $service): static {
        if ($this->services->removeElement($service) && $service->getUser() === $this) {
            $service->setUser(null);
        }
        return $this;
    }

    public function getContacts(): Collection { return $this->contacts; }
    public function addContact(Contact $contact): static {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setUser($this);
        }
        return $this;
    }
    public function removeContact(Contact $contact): static {
        if ($this->contacts->removeElement($contact) && $contact->getUser() === $this) {
            $contact->setUser(null);
        }
        return $this;
    }
}
