<?php

namespace App\Tests\src\Entity;

use App\Entity\Profile;
use App\Factory\ProfileFactory;
use App\Factory\UserFactory;
use App\Utils\Roles;
use Zenstruck\Browser\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;
use JustSteveKing\StatusCode\Http;

class ProfileTest extends KernelTestCase {
  use HasBrowser;
  use ResetDatabase;

  public function testGetProfilesCollectionWillFailNotLoggedIn() {
    $this->browser()
      ->get('api/profiles',[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertNotAuthenticated()
      ->assertStatus(Http::UNAUTHORIZED());
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

  public function testGetProfileNotLoggedIn() {
    $profile = ProfileFactory::createOne(['user' => UserFactory::new(['roles' => [Roles::ACTIVATED, Roles::USER]])]);
    $browser = $this->browser()
      ->get('api/profiles/' . $profile->getId(),[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertStatus(Http::OK());
    $this->checkProfile($browser, $profile->object());
  }
  public function testGetOwnProfile() {
    $profile = ProfileFactory::createOne(['user' => UserFactory::new(['roles' => [Roles::ACTIVATED, Roles::USER]])]);
    $user = $profile->getUser();
    $browser = $this->browser()
      ->actingAs($user)
      ->get('api/profiles/' . $profile->getId(),[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertStatus(Http::OK());
    $this->checkProfile($browser, $profile->object());

  }
  public function testGetProfileOfOtherUser() {
    $profile1 = ProfileFactory::createOne();
    $profile2 = ProfileFactory::createOne(['user' => UserFactory::new(['roles' => [Roles::ACTIVATED, Roles::USER]])]);
    $user1 = $profile1->getUser();
    $browser = $this->browser()
      ->actingAs($user1)
      ->get('api/profiles/' . $profile2->getId(),[
        'headers' => ['Content-Type' => 'application/json']
      ]);
    $this->checkProfile($browser, $profile2->object());
  }


  private function checkProfile(KernelBrowser $browser, Profile $refrenceProfile) {
    $browser->assertJsonMatches('id', $refrenceProfile->getId())
      ->assertJsonMatches('firstName', $refrenceProfile->getFirstName())
      ->assertJsonMatches('lastName', $refrenceProfile->getLastName())
      ->assertJsonMatches('description', $refrenceProfile->getDescription())
      ->assertJsonMatches('theme.id', $refrenceProfile->getTheme()->getId())
      ->assertJsonMatches('theme.name', $refrenceProfile->getTheme()->getName())
      ->assertJsonMatches('theme.description', $refrenceProfile->getTheme()->getDescription())
      ->assertJsonMatches('theme.premium', $refrenceProfile->getTheme()->isPremium());
  }
}
