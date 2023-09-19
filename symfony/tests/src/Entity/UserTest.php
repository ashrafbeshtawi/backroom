<?php

namespace App\Tests\src\Entity;

use App\Entity\User;
use App\Factory\ProfileFactory;
use App\Factory\UserFactory;
use App\Repository\UserRepository;
use App\Security\Hasher;
use App\Tests\src\TestHelper;
use App\Utils\Roles;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;
use JustSteveKing\StatusCode\Http;

class UserTest extends WebTestCase {
  use HasBrowser;
  use ResetDatabase;


  public function testGetWhoAmI() {
    $user = UserFactory::createOne();
    $this->browser()
      ->actingAs($user)
      ->get('api/users/whoami/')
      ->assertStatus(Http::OK());
  }

  public function testGetWhoAmIWillFailWhenNotLoggedIn() {
    $this->browser()
      ->get('api/users/whoami/')
      ->assertStatus(Http::NOT_FOUND());
  }
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
  public function testLoginUserWillFailDueToWrongPassword() {
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

    $this->browser()
      ->post('api/login_check',[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'username' => 'test@test.com',
          'password' => 'wrongpassword',
        ],
      ])
      ->assertStatus(Http::UNAUTHORIZED());
  }
  public function testLoginUser() {
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

    $this->browser()
      ->post('api/login_check',[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'username' => 'test@test.com',
          'password' => 'password123',
        ],
      ])
      ->assertStatus(Http::OK())
      ->assertJson();
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
  public function testGetUsersWithAdminRole() {
    $user = UserFactory::createOne(['roles' => [Roles::ADMIN]]);
    $this->browser()
      ->actingAs($user)
      ->get('api/users')
      ->assertStatus(Http::OK());
  }
  public function testActivateUser() {
    $user = UserFactory::createOne();
    $secret = Hasher::generateActivationHash($user->getPassword());
    $this->browser()
      ->actingAs($user)
      ->get('api/activate/'. $user->getId() . '/' . $secret)
      ->assertStatus(Http::OK());

    $this->browser()
      ->actingAs($user)
      ->get('api/users/' . $user->getId())
      ->assertStatus(Http::OK())
      ->assertJson()
      ->assertJsonMatches('roles', [Roles::USER, Roles::ACTIVATED]);
  }

}
