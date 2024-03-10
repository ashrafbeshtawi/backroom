<?php

namespace App\Security\Voter;

use App\Entity\Profile;
use App\Entity\User;
use App\Utils\Roles;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class ProfileVoter extends Voter {
    public const EDIT = 'PROFILE_EDIT';
    public const VIEW = 'PROFILE_VIEW';

    protected function supports(string $attribute, mixed $subject): bool {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof Profile;
    }

  /**
   * @param string $attribute
   * @param mixed $subject
   * @param TokenInterface $token
   * @return bool
   */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool {
      /** @var User $userFromEntity */
      $userFromEntity = $subject->getUser();
      /** @var User $loggedInUser */
      $loggedInUser = $token->getUser();

      // if user not found then bail out
      if (!$userFromEntity) {
        return false;
      }

      // Read Profile is possible if owner is activated
      if ($attribute === self::VIEW) {
        return $userFromEntity->hasRole(Roles::ACTIVATED) || $loggedInUser?->hasRole(Roles::ADMIN);
      // Edit is possible if caller own the profile
      } else {
        return $loggedInUser?->getId() === $userFromEntity?->getId() || $loggedInUser?->hasRole(Roles::ADMIN);
      }
    }
}
