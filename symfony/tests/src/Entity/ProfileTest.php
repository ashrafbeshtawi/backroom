<?php

namespace App\Tests\src\Entity;

use App\Entity\User;
use App\Factory\ProfileFactory;
use App\Factory\UserFactory;
use App\Utils\Roles;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\ResetDatabase;
use JustSteveKing\StatusCode\Http;

class ProfileTest extends KernelTestCase {
  use HasBrowser;
  use ResetDatabase;

  public function testGetProfiles() {
    $profile = ProfileFactory::createOne(['user' => UserFactory::new(['roles' => [Roles::ACTIVATED, Roles::USER]])]);
    $this->browser()
      ->actingAs($profile->getUser())
      ->get('api/profiles/' . $profile->getId(),[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertStatus(Http::OK())
      ->assertJsonMatches('id', $profile->getId())
      ->assertJsonMatches('firstName', $profile->getFirstName())
      ->assertJsonMatches('lastName', $profile->getLastName())
      ->assertJsonMatches('description', $profile->getDescription());
  }

  public function testGetProfilesCollectionWillFailWithoutLogin() {
    $this->browser()
      ->get('api/profiles/',[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertNotAuthenticated()
      ->assertStatus(Http::UNAUTHORIZED());
  }
  public function testGetProfilesCollectionWillFailWithoutPermission() {
    $profile = ProfileFactory::createOne(['user' => UserFactory::new(['roles' => [Roles::ACTIVATED, Roles::USER]])]);

    $this->browser()
      ->actingAs($profile->getUser())
      ->get('api/profiles/',[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::FORBIDDEN());
  }








}
