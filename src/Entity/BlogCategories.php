<?php

namespace App\Entity;

use App\Repository\BlogCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=BlogCategoriesRepository::class)
 */
class BlogCategories
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
    private $blog_category_name;

    /**
     * @ORM\OneToMany(targetEntity=Blogs::class, mappedBy="blog_category")
     */
    private $blogs;

    public function __construct()
    {
        $this->blogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBlogCategoryName(): ?string
    {
        return $this->blog_category_name;
    }

    public function setBlogCategoryName(string $blog_category_name): self
    {
        $this->blog_category_name = $blog_category_name;

        return $this;
    }

    /**
     * @return Collection<int, Blogs>
     */
    public function getBlogs(): Collection
    {
        return $this->blogs;
    }

    public function addBlog(Blogs $blog): self
    {
        if (!$this->blogs->contains($blog)) {
            $this->blogs[] = $blog;
            $blog->setBlogCategory($this);
        }

        return $this;
    }

    public function removeBlog(Blogs $blog): self
    {
        if ($this->blogs->removeElement($blog)) {
            // set the owning side to null (unless already changed)
            if ($blog->getBlogCategory() === $this) {
                $blog->setBlogCategory(null);
            }
        }

        return $this;
    }
}
