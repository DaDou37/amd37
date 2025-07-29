<?php

namespace App\Entity;

use App\Repository\ProjectCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a category that groups multiple projects.
 * 
 * Each project category includes a name, slug, description, image,
 * and is related to multiple projects.
 */
#[ORM\Entity(repositoryClass: ProjectCategoryRepository::class)]
class ProjectCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * The display name of the category.
     */
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * URL-friendly version of the name.
     */
    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    /**
     * Detailed description of the category.
     */
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    /**
     * Image filename or path representing the category.
     */
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    /**
     * @var Collection<int, Project> The projects associated with this category.
     */
    #[ORM\OneToMany(targetEntity: Project::class, mappedBy: 'projectCategory')]
    private Collection $projects;

    /**
     * Initializes the projects collection.
     */
    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    // --- Getters & Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;
        return $this;
    }

    /**
     * Returns all projects assigned to this category.
     *
     * @return Collection<int, Project>
     */
    public function getProjects(): Collection
    {
        return $this->projects;
    }

    /**
     * Adds a project to this category.
     */
    public function addProject(Project $project): static
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setProjectCategory($this);
        }

        return $this;
    }

    /**
     * Removes a project from this category.
     */
    public function removeProject(Project $project): static
    {
        if ($this->projects->removeElement($project)) {
            // Ensure the owning side is also cleared
            if ($project->getProjectCategory() === $this) {
                $project->setProjectCategory(null);
            }
        }

        return $this;
    }

    /**
     * Converts the category to a string for display (e.g. in forms).
     */
    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
