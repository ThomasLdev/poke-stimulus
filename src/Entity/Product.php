<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $sku = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?int $shippingDelay = null;

    /**
     * @var Collection<int, ProductImage>
     */
    #[ORM\OneToMany(targetEntity: ProductImage::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $images;

    /**
     * @var Collection<int, ProductAttribute>
     */
    #[ORM\OneToMany(targetEntity: ProductAttribute::class, mappedBy: 'product', orphanRemoval: true)]
    private Collection $attributes;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->attributes = new ArrayCollection();
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

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): static
    {
        $this->sku = $sku;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getShippingDelay(): ?int
    {
        return $this->shippingDelay;
    }

    public function setShippingDelay(?int $shippingDelay): static
    {
        $this->shippingDelay = $shippingDelay;

        return $this;
    }

    /**
     * @return Collection<int, ProductImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(ProductImage $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setProduct($this);
        }

        return $this;
    }

    public function removeImage(ProductImage $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduct() === $this) {
                $image->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductAttribute>
     */
    public function getAttributes(): Collection
    {
        return $this->attributes;
    }

    public function addAttribute(ProductAttribute $attribute): static
    {
        if (!$this->attributes->contains($attribute)) {
            $this->attributes->add($attribute);
            $attribute->setProduct($this);
        }

        return $this;
    }

    public function removeAttribute(ProductAttribute $attribute): static
    {
        if ($this->attributes->removeElement($attribute)) {
            // set the owning side to null (unless already changed)
            if ($attribute->getProduct() === $this) {
                $attribute->setProduct(null);
            }
        }

        return $this;
    }
}
