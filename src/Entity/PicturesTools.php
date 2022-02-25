<?php

namespace App\Entity;

use App\Repository\PicturesToolsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PicturesToolsRepository::class)
 */
class PicturesTools
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
    private $picture_tool_name;

    /**
     * @ORM\ManyToOne(targetEntity=Tools::class, inversedBy="picturesTools")
     */
    private $tool;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPictureToolName(): ?string
    {
        return $this->picture_tool_name;
    }

    public function setPictureToolName(string $picture_tool_name): self
    {
        $this->picture_tool_name = $picture_tool_name;

        return $this;
    }

    public function getTool(): ?Tools
    {
        return $this->tool;
    }

    public function setTool(?Tools $tool): self
    {
        $this->tool = $tool;

        return $this;
    }
}
