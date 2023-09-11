<?php

namespace App\Tests\src\Entity;

use App\Factory\ProfileFactory;
use App\Factory\UserFactory;
use App\Utils\Roles;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;
use JustSteveKing\StatusCode\Http;

class ProfileTest extends KernelTestCase {
  use HasBrowser;
  use ResetDatabase;

  public function testGetProfilesCollectionWillFailWithoutPermission() {
    $user = UserFactory::createOne();
    $this->browser()
      ->actingAs($user)
      ->get('api/profiles',[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::FORBIDDEN());
  }

  public function testGetProfilesCollectionAsAdmin() {
    $user = UserFactory::createOne(['roles' => [Roles::ACTIVATED, Roles::USER, Roles::ADMIN]]);
    $this->browser()
      ->actingAs($user)
      ->get('api/profiles',[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::OK());
  }

  public function testGetProfilesCollectionAsNormalUserWillFail() {
    $user = UserFactory::createOne(['roles' => [Roles::ACTIVATED, Roles::USER]]);
    $this->browser()
      ->actingAs($user)
      ->get('api/profiles',[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::FORBIDDEN());
  }

  public function testGetProfile() {
    $profile = ProfileFactory::createOne(['user' => UserFactory::createOne(['roles' => [Roles::ACTIVATED, Roles::USER]])]);
    $user = $profile->getUser();
    $this->browser()
      ->actingAs($user)
      ->get('api/profiles/' . $user->getId(),[
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
      ->get('api/profiles',[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertNotAuthenticated()
      ->assertStatus(Http::UNAUTHORIZED());
  }








}
