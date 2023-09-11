<?php

namespace App\Tests\src\Entity;

use App\Factory\ProfileFactory;
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



}
