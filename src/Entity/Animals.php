<?php

namespace App\Entity;

use App\Repository\AnimalsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AnimalsRepository::class)
 */
class Animals
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
    private $animal_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $animal_picture;

    /**
     * @ORM\Column(type="text")
     */
    private $animal_content;

    /**
     * @ORM\ManyToOne(targetEntity=AnimalsCategories::class, inversedBy="animals")
     */
    private $animal_category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnimalName(): ?string
    {
        return $this->animal_name;
    }

    public function setAnimalName(string $animal_name): self
    {
        $this->animal_name = $animal_name;

        return $this;
    }

    public function getAnimalPicture(): ?string
    {
        return $this->animal_picture;
    }

    public function setAnimalPicture(string $animal_picture): self
    {
        $this->animal_picture = $animal_picture;

        return $this;
    }

    public function getAnimalContent(): ?string
    {
        return $this->animal_content;
    }

    public function setAnimalContent(string $animal_content): self
    {
        $this->animal_content = $animal_content;

        return $this;
    }

    public function getAnimalCategory(): ?AnimalsCategories
    {
        return $this->animal_category;
    }

    public function setAnimalCategory(?AnimalsCategories $animal_category): self
    {
        $this->animal_category = $animal_category;

        return $this;
    }
}
