<?php

namespace App\Entity;

use App\Repository\MediationsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MediationsRepository::class)
 */
class Mediations
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $mediation_history;

    /**
     * @ORM\Column(type="text")
     */
    private $mediation_pedagogy;

    /**
     * @ORM\Column(type="text")
     */
    private $mediation_definition;

    /**
     * @ORM\Column(type="text")
     */
    private $mediation_biography;

    /**
     * @ORM\Column(type="text")
     */
    private $mediation_objectif;

    /**
     * @ORM\Column(type="text")
     */
    private $mediation_methods;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMediationHistory(): ?string
    {
        return $this->mediation_history;
    }

    public function setMediationHistory(string $mediation_history): self
    {
        $this->mediation_history = $mediation_history;

        return $this;
    }

    public function getMediationPedagogy(): ?string
    {
        return $this->mediation_pedagogy;
    }

    public function setMediationPedagogy(string $mediation_pedagogy): self
    {
        $this->mediation_pedagogy = $mediation_pedagogy;

        return $this;
    }

    public function getMediationDefinition(): ?string
    {
        return $this->mediation_definition;
    }

    public function setMediationDefinition(string $mediation_definition): self
    {
        $this->mediation_definition = $mediation_definition;

        return $this;
    }

    public function getMediationBiography(): ?string
    {
        return $this->mediation_biography;
    }

    public function setMediationBiography(string $mediation_biography): self
    {
        $this->mediation_biography = $mediation_biography;

        return $this;
    }

    public function getMediationObjectif(): ?string
    {
        return $this->mediation_objectif;
    }

    public function setMediationObjectif(string $mediation_objectif): self
    {
        $this->mediation_objectif = $mediation_objectif;

        return $this;
    }

    public function getMediationMethods(): ?string
    {
        return $this->mediation_methods;
    }

    public function setMediationMethods(string $mediation_methods): self
    {
        $this->mediation_methods = $mediation_methods;

        return $this;
    }
}
