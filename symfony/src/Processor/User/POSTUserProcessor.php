<?php

namespace App\Processor\User;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class POSTUserProcessor implements ProcessorInterface
{
  public function __construct(
    private readonly UserPasswordHasherInterface $passwordHasher,
    private readonly EntityManagerInterface $entityManager,
    private MailerInterface $mailer
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
    $data->setRoles(['ROLE_USER']);
    $this->entityManager->persist($data);
    $this->entityManager->flush();

    $email = (new Email())
      ->from('hello@example.com')
      ->to('you@example.com')
      //->cc('cc@example.com')
      //->bcc('bcc@example.com')
      //->replyTo('fabien@example.com')
      //->priority(Email::PRIORITY_HIGH)
      ->subject('Time for Symfony Mailer!')
      ->text('Sending emails is fun again!');

    $this->mailer->send($email);
  }
}
