<?php

namespace App\Entity;

use App\Repository\AssociationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass=AssociationsRepository::class)
 */
class Associations
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
    private $association_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $association_address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $association_city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $association_mail;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\Regex("/0[1-9]\d{8}/")
     */
    private $association_phone;
    
    /**
     * @ORM\Column(type="text") 
     * )
     */
    private $association_content;

    /**
     * @ORM\OneToMany(targetEntity=PicturesAssociation::class, mappedBy="association",cascade={"persist"}, orphanRemoval=true)
     */
    private $picturesAssociations;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $association_logo;

    /**
     * @ORM\Column(type="text")
     */
    private $association_statut;

    public function __construct()
    {
        $this->picturesAssociations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssociationName(): ?string
    {
        return $this->association_name;
    }

    public function setAssociationName(string $association_name): self
    {
        $this->association_name = $association_name;

        return $this;
    }

    public function getAssociationAddress(): ?string
    {
        return $this->association_address;
    }

    public function setAssociationAddress(string $association_address): self
    {
        $this->association_address = $association_address;

        return $this;
    }

    public function getAssociationCity(): ?string
    {
        return $this->association_city;
    }

    public function setAssociationCity(string $association_city): self
    {
        $this->association_city = $association_city;

        return $this;
    }

    public function getAssociationMail(): ?string
    {
        return $this->association_mail;
    }

    public function setAssociationMail(string $association_mail): self
    {
        $this->association_mail = $association_mail;

        return $this;
    }

    public function getAssociationPhone(): ?string
    {
        return $this->association_phone;
    }

    public function setAssociationPhone(string $association_phone): self
    {
        $this->association_phone = $association_phone;

        return $this;
    }

    public function getAssociationContent(): ?string
    {
        return $this->association_content;
    }

    public function setAssociationContent(string $association_content): self
    {
        $this->association_content = $association_content;

        return $this;
    }

    /**
     * @return Collection<int, PicturesAssociation>
     */
    public function getPicturesAssociations(): Collection
    {
        return $this->picturesAssociations;
    }

    public function addPicturesAssociation(PicturesAssociation $picturesAssociation): self
    {
        if (!$this->picturesAssociations->contains($picturesAssociation)) {
            $this->picturesAssociations[] = $picturesAssociation;
            $picturesAssociation->setAssociation($this);
        }

        return $this;
    }

    public function removePicturesAssociation(PicturesAssociation $picturesAssociation): self
    {
        if ($this->picturesAssociations->removeElement($picturesAssociation)) {
            // set the owning side to null (unless already changed)
            if ($picturesAssociation->getAssociation() === $this) {
                $picturesAssociation->setAssociation(null);
            }
        }

        return $this;
    }

    public function getAssociationLogo(): ?string
    {
        return $this->association_logo;
    }

    public function setAssociationLogo(string $association_logo): self
    {
        $this->association_logo = $association_logo;

        return $this;
    }

    public function getAssociationStatut(): ?string
    {
        return $this->association_statut;
    }

    public function setAssociationStatut(string $association_statut): self
    {
        $this->association_statut = $association_statut;

        return $this;
    }
}
