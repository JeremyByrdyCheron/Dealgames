<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Announcement>
     */
    #[ORM\OneToMany(targetEntity: Announcement::class, mappedBy: 'categoryId')]
    private Collection $CategoryId;

    public function __construct()
    {
        $this->CategoryId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Announcement>
     */
    public function getCategoryId(): Collection
    {
        return $this->CategoryId;
    }

    public function addCategoryId(Announcement $categoryId): static
    {
        if (!$this->CategoryId->contains($categoryId)) {
            $this->CategoryId->add($categoryId);
            $categoryId->setCategoryId($this);
        }

        return $this;
    }

    public function removeCategoryId(Announcement $categoryId): static
    {
        if ($this->CategoryId->removeElement($categoryId)) {
            // set the owning side to null (unless already changed)
            if ($categoryId->getCategoryId() === $this) {
                $categoryId->setCategoryId(null);
            }
        }

        return $this;
    }
}
