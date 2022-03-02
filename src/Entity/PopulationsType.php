<?php

namespace App\Entity;

use App\Repository\PopulationsTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PopulationsTypeRepository::class)
 */
class PopulationsType
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
    private $population_type_name;

    /**
     * @ORM\ManyToMany(targetEntity=Tools::class, mappedBy="population_type")
     */
    private $tools;

    public function __construct()
    {
        $this->tools = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPopulationTypeName(): ?string
    {
        return $this->population_type_name;
    }

    public function setPopulationTypeName(string $population_type_name): self
    {
        $this->population_type_name = $population_type_name;

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
            $tool->addPopulationType($this);
        }

        return $this;
    }

    public function removeTool(Tools $tool): self
    {
        if ($this->tools->removeElement($tool)) {
            $tool->removePopulationType($this);
        }

        return $this;
    }

}
