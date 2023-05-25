<?php

namespace App\Processor\Product;

use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Product;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class PutProductProcessor implements ProcessorInterface {

  public function __construct(
    private readonly LoggerInterface $logger,
    private readonly EntityManagerInterface $entityManager,
  ){

  }

  public function process($data, Operation $operation, array $uriVariables = [], array $context = []) {
    if (!($data instanceof Product) || !($operation instanceof Put)) {
      throw new BadRequestException('Wrong Operation or Entity');
    }
    $data->setUpdatedAt((new DateTimeImmutable()));
    $this->entityManager->persist($data);
    $this->entityManager->flush();
  }
}
