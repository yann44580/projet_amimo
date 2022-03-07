<?php

namespace App\Entity;

use App\Repository\PopulationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PopulationsRepository::class)
 */
class Populations
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
    private $population_name;

    /**
     * @ORM\ManyToMany(targetEntity=Tools::class, inversedBy="populations")
     */
    private $tool;


    public function __construct()
    {
        $this->tool = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPopulationName(): ?string
    {
        return $this->population_name;
    }

    public function setPopulationName(string $population_name): self
    {
        $this->population_name = $population_name;

        return $this;
    }

    /**
     * @return Collection<int, Tools>
     */
    public function getTool(): Collection
    {
        return $this->tool;
    }

    public function addTool(Tools $tool): self
    {
        if (!$this->tool->contains($tool)) {
            $this->tool[] = $tool;
        }

        return $this;
    }

    public function removeTool(Tools $tool): self
    {
        $this->tool->removeElement($tool);

        return $this;
    }

}
