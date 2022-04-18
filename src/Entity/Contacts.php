<?php

namespace App\Entity;

use App\Repository\ContactsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ContactsRepository::class)
 */
class Contacts
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
    private $contact_content;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Ce champs ne peut être vide"
     * )
     * @Assert\Length(
     *      min = 2,
     *      max = 100,
     *      minMessage = "Ce champs doit comporter au moins {{ limit }} caractères",
     *      maxMessage = "Ce champs doit comporter au maximum {{ limit }} caractères"
     * )

     */
    private $contact_subject;

    /**
     * @ORM\Column(type="datetime")
     */
    private $contact_date;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "Le Courriel '{{ value }}' n'est pas un courriel valide."
     * )
     */
    private $contact_email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contact_fullname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contact_firstname;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactContent(): ?string
    {
        return $this->contact_content;
    }

    public function setContactContent(string $contact_content): self
    {
        $this->contact_content = $contact_content;

        return $this;
    }

    public function getContactSubject(): ?string
    {
        return $this->contact_subject;
    }

    public function setContactSubject(string $contact_subject): self
    {
        $this->contact_subject = $contact_subject;

        return $this;
    }

    public function getContactDate(): ?\DateTimeInterface
    {
        return $this->contact_date;
    }

    public function setContactDate(\DateTimeInterface $contact_date): self
    {
        $this->contact_date = $contact_date;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contact_email;
    }

    public function setContactEmail(string $contact_email): self
    {
        $this->contact_email = $contact_email;

        return $this;
    }

    public function getContactFullname(): ?string
    {
        return $this->contact_fullname;
    }

    public function setContactFullname(string $contact_fullname): self
    {
        $this->contact_fullname = $contact_fullname;

        return $this;
    }

    public function getContactFirstname(): ?string
    {
        return $this->contact_firstname;
    }

    public function setContactFirstname(string $contact_firstname): self
    {
        $this->contact_firstname = $contact_firstname;

        return $this;
    }
};
