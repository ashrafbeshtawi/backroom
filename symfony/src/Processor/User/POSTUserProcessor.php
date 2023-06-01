<?php

namespace App\Processor\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class POSTUserProcessor implements ProcessorInterface
{
  public function __construct(
    private readonly UserPasswordHasherInterface $passwordHasher,
    private readonly EntityManagerInterface $entityManager
  ) {
  }

  public function process($data, Operation $operation, array $uriVariables = [], array $context = []) {

    $hashedPassword = $this->passwordHasher->hashPassword(
      $data,
      $data->getPassword()
    );
    $data->setPassword($hashedPassword);
    $data->eraseCredentials();
    $this->entityManager->persist($data);
    $this->entityManager->flush();

  }
}
