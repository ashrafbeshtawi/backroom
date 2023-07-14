<?php

namespace App\Provider;

use ApiPlatform\State\ProviderInterface;
use \ApiPlatform\Metadata\Operation;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ActivateUserProvider implements ProviderInterface
{
  public function __construct(
    private readonly EntityManagerInterface $entityManager,
  ) {
  }

  /**
   * Provides the user based on the given id
   * the purpose of the provider is to select the user
   * while ognoring the key, which will be used by the controller
   * @param Operation $operation
   * @param array $uriVariables
   * @param array $context
   * @return User
   */
  public function provide(Operation $operation, array $uriVariables = [], array $context = []): User {
    return $this->entityManager->find(User::class, $uriVariables['id']);
  }

}
