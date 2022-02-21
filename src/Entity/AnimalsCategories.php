<?php

namespace App\Entity;

use App\Repository\AnimalsCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimalsCategoriesRepository::class)
 */
class AnimalsCategories
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
    private $animal_category_name;

    /**
     * @ORM\OneToMany(targetEntity=Animals::class, mappedBy="animal_category")
     */
    private $animals;

    /**
     * @ORM\ManyToMany(targetEntity=Tools::class, mappedBy="animal_category")
     */
    private $tools;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->tools = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimalCategoryName(): ?string
    {
        return $this->animal_category_name;
    }

    public function setAnimalCategoryName(string $animal_category_name): self
    {
        $this->animal_category_name = $animal_category_name;

        return $this;
    }

    /**
     * @return Collection<int, Animals>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animals $animal): self
    {
        if (!$this->animals->contains($animal)) {
            $this->animals[] = $animal;
            $animal->setAnimalCategory($this);
        }

        return $this;
    }

    public function removeAnimal(Animals $animal): self
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getAnimalCategory() === $this) {
                $animal->setAnimalCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Tools>
     */
    public function getTools(): Collection
    {
        return $this->tools;
    }

    public function addTool(Tools $tool): self
    {
        if (!$this->tools->contains($tool)) {
            $this->tools[] = $tool;
            $tool->addAnimalCategory($this);
        }

        return $this;
    }

    public function removeTool(Tools $tool): self
    {
        if ($this->tools->removeElement($tool)) {
            $tool->removeAnimalCategory($this);
        }

        return $this;
    }
}
