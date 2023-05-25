<?php

namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *  A Category
 */
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Post(),
    new Put(),
    new Delete(),
  ],
  normalizationContext: ['groups' => ['read']],
  denormalizationContext: ['groups' => ['write']]
)]
#[Entity]
class Category {

  public function __construct() {
    $this->products = new ArrayCollection();
    $this->createdAt = new \DateTimeImmutable();
    $this->updatedAt = new \DateTimeImmutable();
  }

  /**
   * The id of the Category
   * @var int|null
   */
  #[Id]
  #[GeneratedValue]
  #[Column(type: Types::INTEGER)]
  #[Groups(['read'])]
  private ?int $id = null;

  /**
   * The name of the Category
   * @var string
   */
  #[Column(type: Types::STRING)]
  #[Groups(['read', 'write'])]
  private string $name = '';

  /**
   * The description of the Category
   * @var string
   */
  #[Column(type: Types::STRING)]
  #[Groups(['read', 'write'])]
  private string $description = '';

  /**
   * The hidden state of the Category
   * @var bool
   */
  #[Column(type: Types::BOOLEAN)]
  #[Groups(['write'])]
  private bool $hidden = false;

  /**
   * The deletion state of the Category
   * @var bool
   */
  #[Column(type: Types::BOOLEAN)]
  #[Groups(['write'])]
  private bool $deleted = false;

  /**
   * The listing date of the Category
   * @var ?DateTimeInterface
   */
  #[Column(type: Types::DATETIME_MUTABLE)]
  #[Groups(['read'])]
  private ?DateTimeInterface $createdAt = null;

  /**
   * The date of the last update of Category
   * @var ?DateTimeInterface
   */
  #[Column(type: Types::DATETIME_MUTABLE)]
  #[Groups(['read'])]
  private ?DateTimeInterface $updatedAt = null;
  /**
   * @return iterable
   */

  /**
   * The products of this Category
   */
  #[OneToMany(
    mappedBy: 'category',
    targetEntity: Product::class,
    cascade: ['persist', 'remove']
  )]
  #[Groups(['read'])]
  private iterable $products;

  public function getProducts(): iterable {
    return $this->products;
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
  public function getName(): string {
    return $this->name;
  }

  /**
   * @param string $name
   */
  public function setName(string $name): void {
    $this->name = $name;
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

  /**
   * @return bool
   */
  public function isHidden(): bool {
    return $this->hidden;
  }

  /**
   * @param bool $hidden
   */
  public function setHidden(bool $hidden): void {
    $this->hidden = $hidden;
  }

  /**
   * @return bool
   */
  public function isDeleted(): bool {
    return $this->deleted;
  }

  /**
   * @param bool $deleted
   */
  public function setDeleted(bool $deleted): void {
    $this->deleted = $deleted;
  }

  /**
   * @return DateTimeInterface|null
   */
  public function getCreatedAt(): ?DateTimeInterface
  {
    return $this->createdAt;
  }

  /**
   * @return DateTimeInterface|null
   */
  public function getUpdatedAt(): ?DateTimeInterface
  {
    return $this->updatedAt;
  }

  /**
   * @param DateTimeInterface|null $createdAt
   */
  public function setCreatedAt(?DateTimeInterface $createdAt): void
  {
    $this->createdAt = $createdAt;
  }

  /**
   * @param DateTimeInterface|null $updatedAt
   */
  public function setUpdatedAt(?DateTimeInterface $updatedAt): void
  {
    $this->updatedAt = $updatedAt;
  }


}
