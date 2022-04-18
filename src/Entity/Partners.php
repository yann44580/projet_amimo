<?php

namespace App\Entity;

use App\Repository\PartnersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PartnersRepository::class)
 */
class Partners
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
    private $partner_name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $partner_address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $partner_city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $partner_mail;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Regex("/0[1-9]\d{8}/")
     */
    private $partner_phone;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $partner_content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $partner_picture;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $partner_web_link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $partner_referent;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPartnerName(): ?string
    {
        return $this->partner_name;
    }

    public function setPartnerName(string $partner_name): self
    {
        $this->partner_name = $partner_name;

        return $this;
    }

    public function getPartnerAddress(): ?string
    {
        return $this->partner_address;
    }

    public function setPartnerAddress(string $partner_address): self
    {
        $this->partner_address = $partner_address;

        return $this;
    }

    public function getPartnerCity(): ?string
    {
        return $this->partner_city;
    }

    public function setPartnerCity(string $partner_city): self
    {
        $this->partner_city = $partner_city;

        return $this;
    }

    public function getPartnerMail(): ?string
    {
        return $this->partner_mail;
    }

    public function setPartnerMail(string $partner_mail): self
    {
        $this->partner_mail = $partner_mail;

        return $this;
    }

    public function getPartnerPhone(): ?string
    {
        return $this->partner_phone;
    }

    public function setPartnerPhone(string $partner_phone): self
    {
        $this->partner_phone = $partner_phone;

        return $this;
    }

    public function getPartnerContent(): ?string
    {
        return $this->partner_content;
    }

    public function setPartnerContent(string $partner_content): self
    {
        $this->partner_content = $partner_content;

        return $this;
    }

    public function getPartnerPicture(): ?string
    {
        return $this->partner_picture;
    }

    public function setPartnerPicture(string $partner_picture): self
    {
        $this->partner_picture = $partner_picture;

        return $this;
    }

    public function getPartnerWebLink(): ?string
    {
        return $this->partner_web_link;
    }

    public function setPartnerWebLink(?string $partner_web_link): self
    {
        $this->partner_web_link = $partner_web_link;

        return $this;
    }

    public function getPartnerReferent(): ?string
    {
        return $this->partner_referent;
    }

    public function setPartnerReferent(?string $partner_referent): self
    {
        $this->partner_referent = $partner_referent;

        return $this;
    }
}

