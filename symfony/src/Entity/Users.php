<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Id;


#[ApiResource]
#[Entity]
#[Table(name: 'users', schema: 'public')]
class Users {

  #[Id]
  #[GeneratedValue()]
  #[Column(name: 'id', type: 'integer')]
  private int $id;

  #[Column(name: 'name', type: 'string')]
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
