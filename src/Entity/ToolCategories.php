<?php

namespace App\Entity;

use App\Repository\ToolCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ToolCategoriesRepository::class)
 */
class ToolCategories
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
    private $tool_category_name;

    /**
     * @ORM\OneToMany(targetEntity=Tools::class, mappedBy="category_tool")
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

    public function getToolCategoryName(): ?string
    {
        return $this->tool_category_name;
    }

    public function setToolCategoryName(string $tool_category_name): self
    {
        $this->tool_category_name = $tool_category_name;

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
            $tool->setCategoryTool($this);
        }

        return $this;
    }

    public function removeTool(Tools $tool): self
    {
        if ($this->tools->removeElement($tool)) {
            // set the owning side to null (unless already changed)
            if ($tool->getCategoryTool() === $this) {
                $tool->setCategoryTool(null);
            }
        }

        return $this;
    }
}
