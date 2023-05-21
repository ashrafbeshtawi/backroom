<?php

namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Symfony\Component\PropertyInfo\Type;

/**
 *  A Manufacturer
 */
#[ApiResource]
#[Entity]
class Manufacturer {
  /**
   * The id of the Manufacturer
   * @var int|null
   */
  #[Id]
  #[GeneratedValue]
  #[Column(type: Types::INTEGER)]
  private ?int $id = null;

  /**
   * @return int|null
   */
  public function getId(): ?int
  {
    return $this->id;
  }

  /**
   * @param int|null $id
   */
  public function setId(?int $id): void
  {
    $this->id = $id;
  }

  /**
   * The name of the Manufacturer
   * @var string
   */
  #[Column(type: Types::STRING)]
  private string $name = '';

  /**
   * The description of the Manufacturer
   * @var string
   */
  #[Column(type: Types::STRING)]
  private string $description = '';

  /**
   * The country code of the Manufacturer
   * @var string
   */
  #[Column(type: Types::STRING, length: 3)]
  private string $countryCode = '';

  /**
   * The listing date of the Manufacturer
   * @var ?DateTimeInterface
   */
  #[Column(type: Types::DATETIME_MUTABLE)]
  private ?DateTimeInterface $listedDate = null;

  /**
   * @return iterable
   */
  public function getProducts(): iterable
  {
    return $this->products;
  }


  /**
   * The products of this Manufacturer
   */
    #[OneToMany(
      mappedBy: 'manufacturer',
      targetEntity: Product::class,
      cascade: ['persist', 'remove']
    )]
    private iterable $products;

    public function __construct() {
      $this->products = new ArrayCollection();
    }

  /**
   * @return string
   */
  public function getDescription(): string
  {
    return $this->description;
  }

  /**
   * @param string $description
   */
  public function setDescription(string $description): void
  {
    $this->description = $description;
  }

  /**
   * @return string
   */
  public function getCountryCode(): string
  {
    return $this->countryCode;
  }

  /**
   * @param string $countryCode
   */
  public function setCountryCode(string $countryCode): void
  {
    $this->countryCode = $countryCode;
  }

  /**
   * @return DateTimeInterface|null
   */
  public function getListedDate(): ?DateTimeInterface
  {
    return $this->listedDate;
  }

  /**
   * @param DateTimeInterface|null $listedDate
   */
  public function setListedDate(?DateTimeInterface $listedDate): void
  {
    $this->listedDate = $listedDate;
  }

  /**
   * @param string $name
   */
  public function setName(string $name): void
  {
    $this->name = $name;
  }

  /**
   * @return string
   */
  public function getName(): string {
    return $this->name;
  }
}
