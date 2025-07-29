<?php

namespace App\Entity;

use App\Repository\ProjectTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a type of project (e.g. Engine, Maintenance, Diagnostics).
 *
 * Each type can be associated with multiple projects.
 */
#[ORM\Entity(repositoryClass: ProjectTypeRepository::class)]
class ProjectType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * The display name of the project type.
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * The slug used in URLs or routing.
     */
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * @var Collection<int, Project> The projects assigned to this type.
     */
    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Project::class)]
    private Collection $projects;

    /**
     * Initializes the projects collection.
     */
    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    /**
     * Returns the ID of the project type.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Returns the name of the project type.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Sets the name of the project type.
     */
    public function setName(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns the slug of the project type.
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Sets the slug of the project type.
     */
    public function setSlug(string $slug): static
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * String representation for forms or logs.
     */
    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
