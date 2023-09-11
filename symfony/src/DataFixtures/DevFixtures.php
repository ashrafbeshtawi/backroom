<?php

namespace App\DataFixtures;

use App\Entity\Profile;
use App\Entity\Theme;
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
    // Create basic Theme
    $theme = new Theme();
    $theme->setName('basic');
    $theme->setDescription('Vanilla Style');
    $theme->setPermium(false);
    $manager->persist($theme);

    // create Admin
    $user->setEmail('admin@admin.com');
    $user->setPassword($this->passwordHasher->hashPassword($user, 'strongPassword'));
    $user->setRoles([Roles::USER, Roles::ACTIVATED, Roles::ADMIN]);
    $manager->persist($user);
    $manager->flush();



    // Create Profile of Admin
    $profile->setFirstName('Ashraf');
    $profile->setLastName('Beshtawi');
    $profile->setDescription('Your lovely Admin');
    $profile->setTheme($theme);
    $profile->setUser($user);
    $manager->persist($profile);
    $manager->flush();


    // Assign Profile to Admin
    $user->setProfile($profile);
    $manager->persist($user);
    $manager->flush();
  }
}
