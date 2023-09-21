<?php

namespace App\Tests\src\Entity;

use App\Factory\ThemeFactory;
use App\Factory\UserFactory;
use App\Utils\Roles;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;
use JustSteveKing\StatusCode\Http;

class ThemeTest extends KernelTestCase {
  use HasBrowser;
  use ResetDatabase;

  public function testGetThemesCollection() {
    ThemeFactory::createMany(5);
    $this->browser()
      ->get('api/themes',[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertNotAuthenticated()
      ->assertStatus(Http::OK())
      ->assertJsonMatches('"hydra:totalItems"', 5);
  }

  public function testGetThemes() {
    $theme = ThemeFactory::createOne();
    $this->browser()
      ->get('api/themes/' . $theme->getId(),[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertNotAuthenticated()
      ->assertStatus(Http::OK())
      ->assertJsonMatches('id', $theme->getId())
      ->assertJsonMatches('name', $theme->getName())
      ->assertJsonMatches('description', $theme->getDescription())
      ->assertJsonMatches('premium', $theme->isPremium());
  }

  public function testPostThemesWillFailNotLoggedIn() {
    $this->browser()
      ->post('api/themes',[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'name' => 'dummy',
          'description' => 'dummy',
          'premium' => false,
        ],
      ])
      ->assertNotAuthenticated()
      ->assertStatus(Http::UNAUTHORIZED());
  }

  public function testPostThemesWillFailNotAdmin() {
    $user = UserFactory::createOne();
    $this->browser()
      ->actingAs($user)
      ->post('api/themes',[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'name' => 'dummy',
          'description' => 'dummy',
          'premium' => false,
        ],
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::FORBIDDEN());
  }

  public function testPostThemesAsAdmin() {
    $user = UserFactory::createOne(['roles' => [Roles::ADMIN]]);
    $this->browser()
      ->actingAs($user)
      ->post('api/themes',[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'name' => 'dummy',
          'description' => 'dummy',
          'premium' => false,
        ],
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::CREATED())
      ->assertJsonMatches('name', 'dummy')
      ->assertJsonMatches('description', 'dummy')
      ->assertJsonMatches('premium', false);
  }

  public function testPutThemesWillFailNotLoggedIn() {
    $theme = ThemeFactory::createOne();
    $this->browser()
      ->put('api/themes/' . $theme->getId(),[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'name' => 'dummy',
          'description' => 'dummy',
          'premium' => false,
        ],
      ])
      ->assertNotAuthenticated()
      ->assertStatus(Http::UNAUTHORIZED());
  }

  public function testPutThemesWillFailNotAdmin() {
    $theme = ThemeFactory::createOne();
    $user = UserFactory::createOne();
    $this->browser()
      ->actingAs($user)
      ->put('api/themes/' . $theme->getId(),[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'name' => 'dummy',
          'description' => 'dummy',
          'premium' => false,
        ],
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::FORBIDDEN());
  }

  public function testPutThemesAsAdmin() {
    $theme = ThemeFactory::createOne();
    $user = UserFactory::createOne(['roles' => [Roles::ADMIN]]);
    $this->browser()
      ->actingAs($user)
      ->put('api/themes/' . $theme->getId(),[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'name' => 'dummy',
          'description' => 'dummy',
          'premium' => false,
        ],
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::OK())
      ->assertJsonMatches('name', 'dummy')
      ->assertJsonMatches('description', 'dummy')
      ->assertJsonMatches('premium', false);
  }

  public function testDeleteThemesWillFailNotLoggedIn() {
    $theme = ThemeFactory::createOne();
    $this->browser()
      ->delete('api/themes/' . $theme->getId(),[
        'headers' => ['Content-Type' => 'application/json'],
      ])
      ->assertNotAuthenticated()
      ->assertStatus(Http::UNAUTHORIZED());
  }

  public function testDeleteThemesWillFailNotAdmin() {
    $theme = ThemeFactory::createOne();
    $user = UserFactory::createOne();
    $this->browser()
      ->actingAs($user)
      ->delete('api/themes/' . $theme->getId(),[
        'headers' => ['Content-Type' => 'application/json'],
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::FORBIDDEN());
  }

  public function testDeleteThemesAsAdmin() {
    $theme = ThemeFactory::createOne();
    $user = UserFactory::createOne(['roles' => [Roles::ADMIN]]);
    $this->browser()
      ->actingAs($user)
      ->delete('api/themes/' . $theme->getId(),[
        'headers' => ['Content-Type' => 'application/json'],
      ])
      ->assertAuthenticated()
      ->assertStatus(Http::NO_CONTENT());
  }



}
