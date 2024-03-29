<?php

namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Put;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 *  A Profile
 */
#[ApiResource(
  operations: [
    new GetCollection(security: "is_granted('ROLE_ADMIN')"),
    new Get(security: "is_granted('PROFILE_VIEW', object)"),
    new Put(security: "is_granted('PROFILE_EDIT', object)"),
  ],
  normalizationContext: ['groups' => ['read']],
  denormalizationContext: ['groups' => ['write']]
)]
#[Entity]
class Profile {
  /**
   * @var int|null
   */
  #[Id]
  #[GeneratedValue]
  #[Column(type: Types::INTEGER)]
  #[Groups(['read'])]
  private ?int $id = null;

  #[ORM\OneToOne(inversedBy: 'profile', targetEntity: User::class)]
  #[ORM\JoinColumn(nullable: false)]
  private User $user;

  /**
   * @var string
   */
  #[Assert\Length(min: 3)]
  #[Column(type: Types::STRING)]
  #[Groups(['read', 'write'])]
  private string $firstName = '';

  /**
   * @var string
   */
  #[Assert\Length(min: 3)]
  #[Column(type: Types::STRING)]
  #[Groups(['read', 'write'])]
  private string $lastName = '';

  /**
   * @var string
   */
  #[Column(type: Types::TEXT)]
  #[Groups(['read', 'write'])]
  private string $description = '';

  #[ORM\ManyToOne(targetEntity: Theme::class)]
  #[ORM\JoinColumn(name: 'theme_id', referencedColumnName: 'id', nullable: false)]
  #[Groups(['read', 'write'])]
  private ?Theme $theme = null;

  #[ORM\OneToMany(mappedBy: 'profile', targetEntity: Picture::class)]
  #[Groups(['read'])]
  private Collection $picture;

  /**
   * @return User
   */
  public function getUser(): User {
    return $this->user;
  }

  /**
   * @param User $user
   * @return Profile
   */
  public function setUser(User $user): self {
    $this->user = $user;
    return $this;
  }
  /**
   * @return int|null
   */
  public function getId(): ?int {
    return $this->id;
  }

  /**
   * @param int|null $id
   */
  public function setId(?int $id): void {
    $this->id = $id;
  }

  /**
   * @return string
   */
  public function getFirstName(): string {
    return $this->firstName;
  }

  /**
   * @param string $firstName
   */
  public function setFirstName(string $firstName): void {
    $this->firstName = $firstName;
  }

  /**
   * @return string
   */
  public function getLastName(): string {
    return $this->lastName;
  }

  /**
   * @param string $lastName
   */
  public function setLastName(string $lastName): void {
    $this->lastName = $lastName;
  }

  /**
   * @return string
   */
  public function getDescription(): string {
    return $this->description;
  }

  /**
   * @param string $description
   */
  public function setDescription(string $description): void {
    $this->description = $description;
  }

  public function getTheme(): ?Theme
  {
      return $this->theme;
  }

  public function setTheme(?Theme $theme): self
  {
      $this->theme = $theme;

      return $this;
  }

  /**
   * @return Collection<int, Picture>
   */
  public function getPicture(): Collection
  {
    return $this->picture;
  }

  public function addPicture(Picture $picture): self
  {
    if (!$this->picture->contains($picture)) {
      $this->picture->add($picture);
      $picture->setProfile($this);
    }
    return $this;
  }

  public function removePicture(Picture $picture): self
  {
    if ($this->picture->removeElement($picture)) {
      // set the owning side to null (unless already changed)
      if ($picture->getProfile() === $this) {
        $picture->setProfile(null);
      }
    }
    return $this;
  }

}
