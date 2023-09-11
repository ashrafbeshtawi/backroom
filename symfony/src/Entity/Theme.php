<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
#[ApiResource]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $permium = null;

    #[ORM\OneToMany(mappedBy: 'theme', targetEntity: Profile::class)]
    private Collection $profile;

    public function __construct()
    {
        $this->profile = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isPermium(): ?bool
    {
        return $this->permium;
    }

    public function setPermium(bool $permium): self
    {
        $this->permium = $permium;

        return $this;
    }

    /**
     * @return Collection<int, Profile>
     */
    public function getProfile(): Collection
    {
        return $this->profile;
    }

    public function addProfile(Profile $profile): self
    {
        if (!$this->profile->contains($profile)) {
            $this->profile->add($profile);
            $profile->setTheme($this);
        }

        return $this;
    }

    public function removeProfile(Profile $profile): self
    {
        if ($this->profile->removeElement($profile)) {
            // set the owning side to null (unless already changed)
            if ($profile->getTheme() === $this) {
                $profile->setTheme(null);
            }
        }

        return $this;
    }
}
