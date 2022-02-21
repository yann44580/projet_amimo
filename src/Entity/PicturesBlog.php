<?php

namespace App\Entity;

use App\Repository\PicturesBlogRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PicturesBlogRepository::class)
 */
class PicturesBlog
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
    private $picture_blog_name;

    /**
     * @ORM\ManyToOne(targetEntity=Blogs::class, inversedBy="picturesBlogs")
     */
    private $blog;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPictureBlogName(): ?string
    {
        return $this->picture_blog_name;
    }

    public function setPictureBlogName(string $picture_blog_name): self
    {
        $this->picture_blog_name = $picture_blog_name;

        return $this;
    }

    public function getBlog(): ?Blogs
    {
        return $this->blog;
    }

    public function setBlog(?Blogs $blog): self
    {
        $this->blog = $blog;

        return $this;
    }
}
