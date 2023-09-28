<?php

namespace App\Security\Voter;

use App\Entity\Picture;
use App\Entity\Profile;
use App\Entity\User;
use App\Utils\Roles;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ImageVoter extends Voter {
    public const UPLOAD = 'IMAGE_UPLOAD';

  public function __construct(private readonly EntityManagerInterface $entityManager) {
  }
    protected function supports(string $attribute, mixed $subject): bool {
        return in_array($attribute, [self::UPLOAD])
            && $subject instanceof Picture;
    }

  /**
   * @param string $attribute
   * @param mixed $subject
   * @param TokenInterface $token
   * @return bool
   */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool {
      /** @var User $loggedInUser */
      $loggedInUser = $token->getUser();
      return true;
      $profile = $this->entityManager->getRepository(Profile::class)
        ->findOneBy(['user' => $loggedInUser]);
      dd($profile);
      /** @var Picture $subject */
      if (
        $attribute === self::UPLOAD
        && in_array($subject->getTitle(), Picture::ALLOWED_TITELS, true)
        ) {

      }


      // Read Profile is possible if owner is activated
      if ($attribute === self::VIEW) {
        return $userFromEntity && $userFromEntity->hasRole(Roles::ACTIVATED);
      // Edit is possible if caller own the profile
      } else {
        return $loggedInUser && $userFromEntity && $loggedInUser->getId() === $userFromEntity->getId();
      }
    }
}
