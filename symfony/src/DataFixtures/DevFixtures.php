<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\User;
use App\Utils\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DevFixtures extends Fixture
{
  public function __construct(
    private readonly UserPasswordHasherInterface $passwordHasher
  ) {
  }

  public function load(ObjectManager $manager): void {
    $user = new User();
    $profile = new Profile();

    $user->setEmail('admin@admin.com');
    $user->setPassword($this->passwordHasher->hashPassword($user, 'strongPassword'));
    $user->setRoles([Roles::USER, Roles::ACTIVATED, Roles::ADMIN]);
    $user->setProfile($profile);

    $profile->setUser($user);
    $profile->setFirstName('Ashraf');
    $profile->setLastName('Beshtawi');
    $profile->setDescription('Your lovely Admin');

    $manager->persist($user);
    $manager->persist($profile);

    $manager->flush();
  }
}
