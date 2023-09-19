<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Webmozart\Assert\Assert;

class CurrentUserProvider implements ProviderInterface {

  public function __construct(
    private readonly TokenStorageInterface $tokenStorage
  ) {
  }

  /**
   * Provides the user based on the given id
   * the purpose of the provider is to select the user
   * while ignoring the key, which will be used by the controller
   * @param Operation $operation
   * @param array $uriVariables
   * @param array $context
   * @return UserInterface|null
   */
  public function provide(Operation $operation, array $uriVariables = [], array $context = []): ?UserInterface {
    $token = $this->tokenStorage->getToken();
    return $token?->getUser();
  }

}
