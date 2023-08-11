<?php

namespace App\Processor\Profile;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Profile;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Webmozart\Assert\Assert;

final class PUTProfileProcessor implements ProcessorInterface
{
  public function __construct(
    private readonly EntityManagerInterface $entityManager,
    private readonly TokenStorageInterface $tokenStorage
  ) {
  }

  /**
   * @param $data
   * @param Operation $operation
   * @param array $uriVariables
   * @param array $context
   * @return void
   */
  public function process($data, Operation $operation, array $uriVariables = [], array $context = []) {
    /** @var User $user */
    $user = $this->tokenStorage->getToken()->getUser();
    /** @var Profile $data */
    $existedProfile = $this->entityManager
      ->getRepository(Profile::class)
      ->findOneBy(['user' => $user]);
    Assert::null($existedProfile, 'Profile already exists');
    $data->setUser($user);
    $this->entityManager->persist($data);
    $this->entityManager->flush();
  }


}
