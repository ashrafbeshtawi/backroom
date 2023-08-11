<?php

namespace App\Tests\src\Entity;

use App\Factory\ProfileFactory;
use App\Factory\UserFactory;
use App\Security\Hasher;
use App\Utils\Roles;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;
use JustSteveKing\StatusCode\Http;

class ProfileTest extends KernelTestCase {
  use HasBrowser;
  use ResetDatabase;

  public function testGetProfiles() {
    $user = UserFactory::createOne(['roles' => [Roles::USER, Roles::ACTIVATED]]);
    $profile = ProfileFactory::createOne(['user' => $user]);
    $this->browser()
      ->get('api/profiles/' . $profile->getId(),[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertStatus(Http::OK());
  }





}
