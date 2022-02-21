<?php

namespace App\Entity;

use App\Repository\PicturesAssociationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PicturesAssociationRepository::class)
 */
class PicturesAssociation
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
    private $picture_association_name;

    /**
     * @ORM\ManyToOne(targetEntity=Associations::class, inversedBy="picturesAssociations")
     */
    private $association;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPictureAssociationName(): ?string
    {
        return $this->picture_association_name;
    }

    public function setPictureAssociationName(string $picture_association_name): self
    {
        $this->picture_association_name = $picture_association_name;

        return $this;
    }

    public function getAssociation(): ?Associations
    {
        return $this->association;
    }

    public function setAssociation(?Associations $association): self
    {
        $this->association = $association;

        return $this;
    }
}
