<?php

namespace App\Entity;

use App\Repository\ToolsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ToolsRepository::class)
 */
class Tools
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tool_title;

    /**
     * @ORM\Column(type="text")
     */
    private $tool_content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tool_picture;

    /**
     * @ORM\Column(type="date")
     */
    private $tool_publication_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tool_author;

    /**
     * @ORM\ManyToMany(targetEntity=AnimalsCategories::class, inversedBy="tools")
     */
    private $animal_category;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="tools")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=ToolCategories::class, inversedBy="tools")
     */
    private $category_tool;

    public function __construct()
    {
        $this->animal_category = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getToolTitle(): ?string
    {
        return $this->tool_title;
    }

    public function setToolTitle(string $tool_title): self
    {
        $this->tool_title = $tool_title;

        return $this;
    }

    public function getToolContent(): ?string
    {
        return $this->tool_content;
    }

    public function setToolContent(string $tool_content): self
    {
        $this->tool_content = $tool_content;

        return $this;
    }

    public function getToolPicture(): ?string
    {
        return $this->tool_picture;
    }

    public function setToolPicture(string $tool_picture): self
    {
        $this->tool_picture = $tool_picture;

        return $this;
    }

    public function getToolPublicationDate(): ?\DateTimeInterface
    {
        return $this->tool_publication_date;
    }

    public function setToolPublicationDate(\DateTimeInterface $tool_publication_date): self
    {
        $this->tool_publication_date = $tool_publication_date;

        return $this;
    }

    public function getToolAuthor(): ?string
    {
        return $this->tool_author;
    }

    public function setToolAuthor(string $tool_author): self
    {
        $this->tool_author = $tool_author;

        return $this;
    }

    /**
     * @return Collection<int, AnimalsCategories>
     */
    public function getAnimalCategory(): Collection
    {
        return $this->animal_category;
    }

    public function addAnimalCategory(AnimalsCategories $animalCategory): self
    {
        if (!$this->animal_category->contains($animalCategory)) {
            $this->animal_category[] = $animalCategory;
        }

        return $this;
    }

    public function removeAnimalCategory(AnimalsCategories $animalCategory): self
    {
        $this->animal_category->removeElement($animalCategory);

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategoryTool(): ?ToolCategories
    {
        return $this->category_tool;
    }

    public function setCategoryTool(?ToolCategories $category_tool): self
    {
        $this->category_tool = $category_tool;

        return $this;
    }
}
