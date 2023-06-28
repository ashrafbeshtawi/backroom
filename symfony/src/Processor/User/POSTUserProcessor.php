<?php

namespace App\Processor\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
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
    /** @var User $data */
    $hashedPassword = $this->passwordHasher->hashPassword(
      $data,
      $data->getPassword()
    );
    $data->setPassword($hashedPassword);
    $data->eraseCredentials();
    $data->setRoles(['ROLE_USER']);
    $this->entityManager->persist($data);
    $this->entityManager->flush();

  }
}
