<?php

namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;

/**
 *  A Product
 */
#[ApiResource]
#[Entity]
class Product {
  /**
   * The id of the Product
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
   * The name of the Product
   * @var string
   */
  #[Column(type: Types::STRING)]
  private string $name = '';

  /**
   * The description of the Product
   * @var string
   */
  #[Column(type: Types::TEXT)]
  private string $description = '';

  /**
   * The MPN (manufacturer part number) of the Product
   * @var string
   */
  #[Column(type: Types::STRING)]
  private string $mpn = '';


  /**
   * The listing date of the Product
   * @var ?DateTimeInterface
   */
  #[Column(type: Types::DATETIME_MUTABLE)]
  private ?DateTimeInterface $issueDate = null;

  /**
   * @return string
   */
  public function getMpn(): string
  {
    return $this->mpn;
  }

  /**
   * @param string $mpn
   */
  public function setMpn(string $mpn): void
  {
    $this->mpn = $mpn;
  }

  /**
   * @return DateTimeInterface|null
   */
  public function getIssueDate(): ?DateTimeInterface
  {
    return $this->issueDate;
  }

  /**
   * @param DateTimeInterface|null $issueDate
   */
  public function setIssueDate(?DateTimeInterface $issueDate): void
  {
    $this->issueDate = $issueDate;
  }

  /**
   * @return Manufacturer|null
   */
  public function getManufacturer(): ?Manufacturer
  {
    return $this->manufacturer;
  }

  /**
   * @param Manufacturer|null $manufacturer
   */
  public function setManufacturer(?Manufacturer $manufacturer): void
  {
    $this->manufacturer = $manufacturer;
  }

  /**
   * The Manufacturer of the Product
   * @var ?Manufacturer
   */
  #[ManyToOne(
    targetEntity: Manufacturer::class,
    inversedBy: "products"
  )]
  private ?Manufacturer $manufacturer = null;

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
