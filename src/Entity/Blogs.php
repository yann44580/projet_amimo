<?php

namespace App\Entity;

use App\Repository\BlogsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogsRepository::class)
 */
class Blogs
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
    private $blog_title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $blog_subtitle;

    /**
     * @ORM\Column(type="text")
     */
    private $blog_content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $blog_author;

    /**
     * @ORM\Column(type="date")
     */
    private $blog_publication_date;

    /**
     * @ORM\OneToMany(targetEntity=PicturesBlog::class, mappedBy="blog")
     */
    private $picturesBlogs;

    /**
     * @ORM\ManyToOne(targetEntity=BlogCategories::class, inversedBy="blogs")
     */
    private $blog_category;

    public function __construct()
    {
        $this->picturesBlogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlogTitle(): ?string
    {
        return $this->blog_title;
    }

    public function setBlogTitle(string $blog_title): self
    {
        $this->blog_title = $blog_title;

        return $this;
    }

    public function getBlogSubtitle(): ?string
    {
        return $this->blog_subtitle;
    }

    public function setBlogSubtitle(?string $blog_subtitle): self
    {
        $this->blog_subtitle = $blog_subtitle;

        return $this;
    }

    public function getBlogContent(): ?string
    {
        return $this->blog_content;
    }

    public function setBlogContent(string $blog_content): self
    {
        $this->blog_content = $blog_content;

        return $this;
    }

    public function getBlogAuthor(): ?string
    {
        return $this->blog_author;
    }

    public function setBlogAuthor(string $blog_author): self
    {
        $this->blog_author = $blog_author;

        return $this;
    }

    public function getBlogPublicationDate(): ?\DateTimeInterface
    {
        return $this->blog_publication_date;
    }

    public function setBlogPublicationDate(\DateTimeInterface $blog_publication_date): self
    {
        $this->blog_publication_date = $blog_publication_date;

        return $this;
    }

    /**
     * @return Collection<int, PicturesBlog>
     */
    public function getPicturesBlogs(): Collection
    {
        return $this->picturesBlogs;
    }

    public function addPicturesBlog(PicturesBlog $picturesBlog): self
    {
        if (!$this->picturesBlogs->contains($picturesBlog)) {
            $this->picturesBlogs[] = $picturesBlog;
            $picturesBlog->setBlog($this);
        }

        return $this;
    }

    public function removePicturesBlog(PicturesBlog $picturesBlog): self
    {
        if ($this->picturesBlogs->removeElement($picturesBlog)) {
            // set the owning side to null (unless already changed)
            if ($picturesBlog->getBlog() === $this) {
                $picturesBlog->setBlog(null);
            }
        }

        return $this;
    }

    public function getBlogCategory(): ?BlogCategories
    {
        return $this->blog_category;
    }

    public function setBlogCategory(?BlogCategories $blog_category): self
    {
        $this->blog_category = $blog_category;

        return $this;
    }
}
