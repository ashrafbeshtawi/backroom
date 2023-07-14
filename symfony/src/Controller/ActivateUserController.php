<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


#[AsController]
final class ActivateUserController extends AbstractController
{

  public function __construct(
    private readonly EntityManagerInterface $entityManager,
    private readonly UserPasswordHasherInterface $passwordHasher,

  ) {
  }

  /**
   * checks if validation key is correct and
   * gives the user the right ROLE_ACTIVATED
   * @param User $user
   * @param Request $request
   * @return Response
   */
  public function __invoke(User $data, Request $request): Response {
    $key = $request->get('key');
    $activationSecret = $this->passwordHasher->hashPassword(
      $data,
      $data->getPassword() . getenv('HASH_KEY')
    );
    $activationSecret = preg_replace('/[^0-9\']/', '', $activationSecret);
    dd($data);
    return new Response($activationSecret. '_' . $key);

  }

}
