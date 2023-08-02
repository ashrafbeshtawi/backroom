<?php

namespace App\Processor\Profile;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Profile;
use Doctrine\ORM\EntityManagerInterface;

final class POSTProfileProcessor implements ProcessorInterface
{
  public function __construct(
    private readonly EntityManagerInterface $entityManager
  ) {
  }

  /**
   * @param $data
   * @param Operation $operation
   * @param array $uriVariables
   * @param array $context
   * @return void
   */
  public function process($data, Operation $operation, array $uriVariables = [], array $context = [])
  {
    /** @var Profile $data */
    var_dump($data);
    dd();
    $this->entityManager->persist($data);
    $this->entityManager->flush();
  }


}
