<?php

namespace App\Processor\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\Profile;
use App\Entity\User;
use App\Repository\ThemeRepository;
use App\Security\Hasher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class POSTUserProcessor implements ProcessorInterface
{
  public function __construct(
    private readonly UserPasswordHasherInterface $passwordHasher,
    private readonly EntityManagerInterface $entityManager,
    private readonly TransportInterface $mailer,
    private readonly ThemeRepository $themeRepository
  ) {
  }

  /**
   * @throws TransportExceptionInterface
   */
  public function process($data, Operation $operation, array $uriVariables = [], array $context = []) {
    /** @var User $data */
    $hashedPassword = $this->passwordHasher->hashPassword(
      $data,
      $data->getPassword()
    );
    $data->setPassword($hashedPassword);
    $data->eraseCredentials();
    // Create Empty Profile
    $profile = new Profile();
    $profile->setUser($data);
    $profile->setTheme($this->themeRepository->fetchDefaultTheme());
    $data->setProfile($profile);
    $data->setRoles(['ROLE_USER']);
    $this->entityManager->persist($data);
    $this->entityManager->flush();

    $activationSecret = Hasher::generateActivationHash($hashedPassword);
    $activationLink = 'api/activate/' .  $data->getId() . '/' . $activationSecret;

    $email = (new Email())
      ->from('noreply@example.com')
      ->to('client@email.com')
      ->subject('Activation code')
      ->html(
        'Sending emails is fun again! <br/>'
        . $activationLink
      );
    $this->mailer->send($email);
  }
}
