<?php

namespace App\Controller;

use App\Entity\User;
use App\Security\Hasher;
use App\Utils\Roles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Webmozart\Assert\Assert;


#[AsController]
final class ActivateUserController extends AbstractController
{

  public function __construct(private readonly EntityManagerInterface $entityManager) {
  }

  /**
   * checks if validation key is correct and
   * gives the user the right ROLE_ACTIVATED
   * @param User $user
   * @param Request $request
   * @return Response
   */
  public function __invoke(User $user, Request $request): Response {
    $secret = $request->get('secret');
    Assert::stringNotEmpty($secret);
    $res = Hasher::isValidActivationHash($secret, $user->getPassword());
    $roles = $user->getRoles();
    if ($res && !in_array(Roles::ACTIVATED, $roles)) {
      $roles[] = Roles::ACTIVATED;
      $user->setRoles($roles);
      $this->entityManager->persist($user);
      $this->entityManager->flush();
    }
    return new Response($res ? 'true' : 'false');

  }

}
