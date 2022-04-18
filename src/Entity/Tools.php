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
     * @ORM\Column(type="date")
     */
    private $tool_publication_date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tool_author;

    /**
     * @ORM\ManyToMany(targetEntity=AnimalsCategories::class, inversedBy="tools")
     * @ORM\JoinColumn(nullable=true)
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

    /**
     * @ORM\ManyToMany(targetEntity=Populations::class, inversedBy="tool")
     */
    private $population;

    /**
     * @ORM\OneToMany(targetEntity=PicturesTools::class, mappedBy="tool",cascade={"persist"}, orphanRemoval=true)
     */
    private $picturesTools;

    /**
     * @ORM\ManyToMany(targetEntity=PopulationsType::class, inversedBy="tools")
     */
    private $population_type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $size_group;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tool_content2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tool_content3;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tool_item;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $document_tool;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tool_content4;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $tool_content5;

    public function __construct()
    {
        $this->animal_category = new ArrayCollection();
        $this->population = new ArrayCollection();
        $this->picturesTools = new ArrayCollection();
        $this->population_type = new ArrayCollection();
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


    /**
     * @return Collection<int, Populations>
     */
    public function getPopulations(): Collection
    {
        return $this->population;
    }

    public function addPopulation(Populations $population): self
    {
        if (!$this->populations->contains($population)) {
            $this->populations[] = $population;
            $population->addTool($this);
        }

        return $this;
    }

    public function removePopulation(Populations $population): self
    {
        if ($this->populations->removeElement($population)) {
            $population->removeTool($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, PicturesTools>
     */
    public function getPicturesTools(): Collection
    {
        return $this->picturesTools;
    }

    public function addPicturesTool(PicturesTools $picturesTool): self
    {
        if (!$this->picturesTools->contains($picturesTool)) {
            $this->picturesTools[] = $picturesTool;
            $picturesTool->setTool($this);
        }

        return $this;
    }

    public function removePicturesTool(PicturesTools $picturesTool): self
    {
        if ($this->picturesTools->removeElement($picturesTool)) {
            // set the owning side to null (unless already changed)
            if ($picturesTool->getTool() === $this) {
                $picturesTool->setTool(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PopulationsType>
     */
    public function getPopulationType(): Collection
    {
        return $this->population_type;
    }

    public function addPopulationType(PopulationsType $populationType): self
    {
        if (!$this->population_type->contains($populationType)) {
            $this->population_type[] = $populationType;
        }

        return $this;
    }

    public function removePopulationType(PopulationsType $populationType): self
    {
        $this->population_type->removeElement($populationType);

        return $this;
    }

    public function getSizeGroup(): ?string
    {
        return $this->size_group;
    }

    public function setSizeGroup(string $size_group): self
    {
        $this->size_group = $size_group;

        return $this;
    }

    public function getToolContent2(): ?string
    {
        return $this->tool_content2;
    }

    public function setToolContent2(?string $tool_content2): self
    {
        $this->tool_content2 = $tool_content2;

        return $this;
    }

    public function getToolContent3(): ?string
    {
        return $this->tool_content3;
    }

    public function setToolContent3(?string $tool_content3): self
    {
        $this->tool_content3 = $tool_content3;

        return $this;
    }

    public function getToolItem(): ?string
    {
        return $this->tool_item;
    }

    public function setToolItem(string $tool_item): self
    {
        $this->tool_item = $tool_item;

        return $this;
    }

    public function getDocumentTool(): ?string
    {
        return $this->document_tool;
    }

    public function setDocumentTool(?string $document_tool): self
    {
        $this->document_tool = $document_tool;

        return $this;
    }

    public function getToolContent4(): ?string
    {
        return $this->tool_content4;
    }

    public function setToolContent4(?string $tool_content4): self
    {
        $this->tool_content4 = $tool_content4;

        return $this;
    }

    public function getToolContent5(): ?string
    {
        return $this->tool_content5;
    }

    public function setToolContent5(?string $tool_content5): self
    {
        $this->tool_content5 = $tool_content5;

        return $this;
    }
}
