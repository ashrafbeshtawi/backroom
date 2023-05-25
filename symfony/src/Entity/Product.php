<?php

namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Processor\Product\PutProductProcessor;
use DateTimeImmutable;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 *  A Product
 */
#[ApiResource(
  operations: [
    new GetCollection(),
    new Get(),
    new Post(),
    new Put(
      processor: PutProductProcessor::class
    ),
    new Delete(),
  ],
  normalizationContext: ['groups' => ['read']],
  denormalizationContext: ['groups' => ['write']]
)]
#[Entity]
class Product {
  public function __construct() {
    $this->createdAt = new DateTimeImmutable();
    $this->updatedAt = new DateTimeImmutable();
  }
  /**
   * The id of the Product
   * @var int|null
   */
  #[Id]
  #[GeneratedValue]
  #[Column(type: Types::INTEGER)]
  #[Groups(['read'])]
  private ?int $id = null;


  /**
   * The name of the Product
   * @var string
   */
  #[Column(type: Types::STRING)]
  #[Groups(['read', 'write'])]
  private string $name = '';

  /**
   * The description of the Product
   * @var string
   */
  #[Column(type: Types::TEXT)]
  #[Groups(['read', 'write'])]
  private string $description = '';

  /**
   * The listing date of the Product
   * @var ?DateTimeInterface
   */
  #[Column(type: Types::DATETIME_IMMUTABLE)]
  #[Groups(['read'])]
  private ?DateTimeInterface $createdAt = null;

  /**
   * The date of the last update of Product
   * @var DateTimeInterface
   */
  #[Column(type: Types::DATETIME_IMMUTABLE)]
  #[Groups(['read'])]
  private DateTimeInterface $updatedAt;

  /**
   * The Category of the Product
   * @var Category
   */
  #[ManyToOne(
    targetEntity: Category::class,
    inversedBy: "products"
  )]
  #[Groups(['read', 'write'])]
  private Category $category;


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
   * @param string $name
   */
  public function setName(string $name): void {
    $this->name = $name;
  }

  /**
   * @return string
   */
  public function getName(): string {
    return $this->name;
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
   * @return Category|null
   */
  public function getCategory(): ?Category {
    return $this->category;
  }

  /**
   * @param Category|null $category
   */
  public function setCategory(?Category $category): void {
    $this->category = $category;
  }

  /**
   * @return DateTimeInterface
   */
  public function getCreatedAt(): DateTimeInterface
  {
    return $this->createdAt;
  }

  /**
   * @param DateTimeInterface $createdAt
   */
  public function setCreatedAt(DateTimeInterface $createdAt): void
  {
    $this->createdAt = $createdAt;
  }

  /**
   * @return DateTimeInterface
   */
  public function getUpdatedAt(): DateTimeInterface
  {
    return $this->updatedAt;
  }

  /**
   * @param DateTimeInterface $updatedAt
   */
  public function setUpdatedAt(DateTimeInterface $updatedAt): void
  {
    $this->updatedAt = $updatedAt;
  }


}
