<?php

namespace App\Tests\src\Entity;

use App\Entity\User;
use App\Factory\UserFactory;
use App\Security\Hasher;
use App\Utils\Roles;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\KernelBrowser;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;
use JustSteveKing\StatusCode\Http;

class UserTest extends KernelTestCase {
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
    $browser = $this->browser()
      ->actingAs($user)
      ->get('api/users/'.$user->getId())
      ->assertStatus(Http::OK());
    $this->checkUser($browser, $user->object());
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

    $browser = $this->browser()
      ->actingAs($user)
      ->get('api/users/' . $user->getId())
      ->assertStatus(Http::OK());

    $userObject = $user->object();
    // Mark reference User as activated
    $userObject->setRoles([Roles::USER, Roles::ACTIVATED]);
    $this->checkUser($browser, $userObject);
  }

  /**
   * @param KernelBrowser $browser
   * @param User $refrenceUser
   * @return void
   */
  private function checkUser(KernelBrowser $browser, User $refrenceUser) {
    $browser->assertJsonMatches('id', $refrenceUser->getId())
      ->assertJsonMatches('email', $refrenceUser->getEmail())
      ->assertJsonMatches('roles', $refrenceUser->getRoles());
  }
}
