<?php

namespace App\Tests\src\Entity;

use App\Factory\UserFactory;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;
use JustSteveKing\StatusCode\Http;

class UserTest extends KernelTestCase {
  use HasBrowser;
  use ResetDatabase;

  public function testCreateUsers() {
    $this->browser()
      ->post('api/users',[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'email' => 'test@test.com',
          'password' => 'password123',
        ],
      ])
      ->assertNotAuthenticated()
      ->assertStatus(Http::CREATED());
  }
  public function testGetUsersWithoutLoginWillFailWithAccessDenied() {

    $this->browser()
      ->get('api/users')
      ->assertNotAuthenticated()
      ->assertStatus(Http::UNAUTHORIZED());
  }

  public function testGetUserWithoutLoginWillFailWithAccessDenied() {
    $this->browser()
      ->get('api/users')
      ->assertNotAuthenticated()
      ->assertStatus(Http::UNAUTHORIZED());
  }
  public function testGetUser() {
    $user = UserFactory::createOne();
    $this->browser()
      ->actingAs($user)
      ->get('api/users/'.$user->getId())
      ->assertStatus(Http::OK());
  }
  public function testGetUsersWithoutAdminRoleWillFaill() {
    $user = UserFactory::createOne();
    $this->browser()
      ->actingAs($user)
      ->get('api/users')
      ->assertStatus(Http::FORBIDDEN());
  }


}
