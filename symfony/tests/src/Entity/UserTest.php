<?php

namespace App\Tests\src\Entity;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\ResetDatabase;

class UserTest extends KernelTestCase {
  use HasBrowser;
  use ResetDatabase;

  public function testGetUsers() {
    $this->browser()
      ->post('api/users',[
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'email' => 'test@test.com',
          'password' => 'password123',
        ],
      ])
      ->assertNotAuthenticated()
      ->assertStatus(201);
  }
  public function testGetUsersWithoutLoginWillFailWithAccessDenied() {

    $this->browser()
      ->get('api/users')
      ->assertNotAuthenticated()
      ->assertStatus(401);
  }

  public function testGetUserWithoutLoginWillFailWithAccessDenied() {
    $this->browser()
      ->get('api/users')
      ->assertNotAuthenticated()
      ->assertStatus(401);
  }

}
