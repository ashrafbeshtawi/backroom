<?php

namespace App\Tests\src\Entity;

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

  public function testCreateProfilesWithoutLoginWillFail() {
    $this->browser()
      ->post('api/profiles',[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'firstName' => 'first name',
          'lastName' => 'last name',
          'description' => 'sample description',
        ],
      ])
      ->assertStatus(Http::UNAUTHORIZED());
  }
  public function testCreateProfiles() {
    $user = UserFactory::createOne(['roles' => [Roles::USER, Roles::ACTIVATED]]);
    $this->browser()
      ->actingAs($user)
      ->post('api/profiles',[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'firstName' => 'first name',
          'lastName' => 'last name',
          'description' => 'sample description',
        ],
      ])
      ->dump()
      ->assertAuthenticated(as: $user)
      ->assertStatus(Http::CREATED());
  }





}
