<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
#[ApiResource]
class User {
  /**
   * @ORM\Id()
   * @ORM\GeneratedValue()
   * @ORM\Column(type="integer")
   */
  private int $id;

   /**
   * @ORM\Column(name="name", type="string")
   */
  private string $name;

  public function getId() {
    return $this->id;
  }
    public function getName() {
    return $this->name;
  }


    public function setId(int $id) {
      $this->id = $id;
  }
    public function setName(string $name) {
      $this->name = $name;
  }


}
