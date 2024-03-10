<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Utils\Roles;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class UserVoter extends Voter {
    public const EDIT = 'USER_EDIT';
    public const VIEW = 'USER_VIEW';

    protected function supports(string $attribute, mixed $subject): bool {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof User;
    }

  /**
   * @param string $attribute
   * @param mixed $subject
   * @param TokenInterface $token
   * @return bool
   */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool {
      /** @var User $subject */
      /** @var User $loggedInUser */
      $loggedInUser = $token->getUser();
      // if user not found or not logged in then bail out
      if (!$subject || !$loggedInUser) {
        return false;
      }

      // for now not differentiating between view and edit
      return $subject->getId() === $loggedInUser->getId() || $loggedInUser->hasRole(Roles::ADMIN);
    }
}
