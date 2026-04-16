<?php

namespace App\Entity;

use App\Repository\AnnouncementRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Attribute as Vich;
use Symfony\Component\HttpFoundation\File\File;
use App\Enum\Category;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: AnnouncementRepository::class)]
class Announcement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\Column]
    private ?DateTime $createdDate = null;

    #[ORM\Column(enumType: Category::class)]
    private ?Category $category = null;

    #[Vich\UploadableField(mapping: 'products', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;


    #[ORM\Column(nullable: true)]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    private ?DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'AnnouncePublished')]
    #[ORM\JoinColumn(name: 'author_id', nullable: false)]
    private ?User $authorId = null;

    #[ORM\ManyToOne(inversedBy: 'AnnouncementInterested')]
    #[ORM\JoinColumn(name: 'interested_user_id', nullable: true)]
    private ?User $InterestedUserId = null;


    public function setImageFile($imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            $this->updatedAt = new DateTimeImmutable();
        }
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDate(): ?DateTime
    {
        return $this->createdDate;
    }

    public function setDate(DateTime $createdDate): static
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getcategory(): ?Category
    {
        return $this->category;
    }

    public function setcategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
    public function getImageFile()
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }
    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAuthorId(): ?User
    {
        return $this->authorId;
    }

    public function setAuthorId(?User $authorId): static
    {
        $this->authorId = $authorId;

        return $this;
    }

    public function getInterestedUserId(): ?User
    {
        return $this->InterestedUserId;
    }

    public function setInterestedUserId(?User $InterestedUserId): static
    {
        $this->InterestedUserId = $InterestedUserId;

        return $this;
    }

    public function __construct()
    {
        $this->createdDate = new DateTime();
    }
}
