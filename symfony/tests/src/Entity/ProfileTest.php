<?php

namespace App\Tests\src\Entity;

use App\Entity\Profile;
use App\Factory\ProfileFactory;
use App\Factory\ThemeFactory;
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

  public function testPutOwnProfile() {
    $theme = ThemeFactory::createOne(['name' => 'changedThemeName', 'description' => 'changedThemeDescription', 'premium' => true]);
    $profile = ProfileFactory::createOne(
      ['user' => UserFactory::new(['roles' => [Roles::ACTIVATED, Roles::USER]])]
    );
    $user = $profile->getUser();
    $refrenceValues = [
      'firstName' => 'changedFirstName',
      'lastName' => 'changedLastName',
      'description' => 'changedDescription',
      'theme.name' => $theme->getName(),
      'theme.description' => $theme->getDescription(),
      'theme.premium' => $theme->isPremium(),
    ];
    $browser = $this->browser()
      ->actingAs($user)
      ->put('api/profiles/' . $profile->getId(),[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'firstName' => $refrenceValues['firstName'],
          'lastName' => $refrenceValues['lastName'],
          'description' => $refrenceValues['description'],
          'theme' => ['id' => $theme->getId()],
        ],
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::OK());
    $this->checkProfileAgainstValues($browser, $refrenceValues);
  }
  public function testPutProfileWillFailNotLoggedIn() {
    $profile = ProfileFactory::createOne(
      ['user' => UserFactory::new(['roles' => [Roles::ACTIVATED, Roles::USER]])]
    );
    $this->browser()
      ->put('api/profiles/' . $profile->getId(),[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'firstName' => 'firstName',
        ],
      ])
      ->assertNotAuthenticated()
      ->assertStatus(Http::UNAUTHORIZED());
  }
  public function testPutProfileWillFailNotOwnProfile() {
    $profile = ProfileFactory::createOne(
      ['user' => UserFactory::new(['roles' => [Roles::ACTIVATED, Roles::USER]])]
    );
    $user = UserFactory::createOne();
    $this->browser()
      ->actingAs($user)
      ->put('api/profiles/' . $profile->getId(),[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'firstName' => 'firstName',
        ],
      ])
      ->assertStatus(Http::FORBIDDEN());
  }
  public function testPutOwnProfileAsAdmin() {
    $theme = ThemeFactory::createOne(['name' => 'changedThemeName', 'description' => 'changedThemeDescription', 'premium' => true]);
    $profile = ProfileFactory::createOne();
    $user = UserFactory::createOne(['roles' => [Roles::ACTIVATED, Roles::USER, Roles::ADMIN]]);
    $refrenceValues = [
      'firstName' => 'changedFirstName',
      'lastName' => 'changedLastName',
      'description' => 'changedDescription',
      'theme.name' => $theme->getName(),
      'theme.description' => $theme->getDescription(),
      'theme.premium' => $theme->isPremium(),
    ];
    $browser = $this->browser()
      ->actingAs($user)
      ->put('api/profiles/' . $profile->getId(),[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'firstName' => $refrenceValues['firstName'],
          'lastName' => $refrenceValues['lastName'],
          'description' => $refrenceValues['description'],
          'theme' => ['id' => $theme->getId()],
        ],
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::OK());
    $this->checkProfileAgainstValues($browser, $refrenceValues);
  }
  public function testPutShareSameTheme() {
    $theme = ThemeFactory::createOne();
    $profile1 = ProfileFactory::createOne();
    $profile2 = ProfileFactory::createOne();
    $refrenceValues = [
      'theme.name' => $theme->getName(),
      'theme.description' => $theme->getDescription(),
      'theme.premium' => $theme->isPremium(),
    ];
    $browser1 = $this->browser()
      ->actingAs($profile1->getUser())
      ->put('api/profiles/' . $profile1->getId(),[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'theme' => ['id' => $theme->getId()],
        ],
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::OK());

    $browser2 = $this->browser()
      ->actingAs($profile2->getUser())
      ->put('api/profiles/' . $profile2->getId(),[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'theme' => ['id' => $theme->getId()],
        ],
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::OK());

    $this->checkProfileAgainstValues($browser1, $refrenceValues);
    $this->checkProfileAgainstValues($browser2, $refrenceValues);

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
  private function checkProfileAgainstValues(KernelBrowser $browser, array $refrenceValues) {
    foreach ($refrenceValues as $key => $value) {
      $browser = $browser->assertJsonMatches($key, $value);
    }
  }
}
