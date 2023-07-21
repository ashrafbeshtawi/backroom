<?php

namespace App\Processor\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use App\security\Hasher;
use App\Utils\Roles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class PUTUserProcessor implements ProcessorInterface
{
  public function __construct(
    private readonly UserPasswordHasherInterface $passwordHasher,
    private readonly EntityManagerInterface $entityManager,
    private readonly TransportInterface $mailer
  ) {
  }

  /**
   */
  public function process($data, Operation $operation, array $uriVariables = [], array $context = []) {
    /** @var User $data */
    if ($this->passwordHasher->needsRehash($data)) {
      $hashedPassword = $this->passwordHasher->hashPassword(
        $data,
        $data->getPassword()
      );
      $data->setPassword($hashedPassword);
      $data->eraseCredentials();
      // if user is not activated yet then resend activation code
      if (!$data->hasRole(Roles::ACTIVATED)) {
        $activationSecret = Hasher::generateActivationHash($data->getPassword());
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
    $this->entityManager->persist($data);
    $this->entityManager->flush();
  }
}
