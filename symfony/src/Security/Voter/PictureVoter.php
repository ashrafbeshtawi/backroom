<?php

namespace App\Security\Voter;

use App\Entity\Picture;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PictureVoter extends Voter {
    public const EDIT = 'PICTURE_EDIT';

  public function __construct() {
  }
    protected function supports(string $attribute, mixed $subject): bool {
        return in_array($attribute, [self::EDIT])
            && $subject instanceof Picture;
    }

  /**
   * @param string $attribute
   * @param Picture $subject
   * @param TokenInterface $token
   * @return bool
   */
    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool {
      /** @var User $loggedInUser */
      $loggedInUser = $token->getUser();
      return $loggedInUser->getProfileId() === $subject->getProfileId();
    }
}
