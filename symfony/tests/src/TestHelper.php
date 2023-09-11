<?php

namespace App\Tests\src;

use App\Repository\UserRepository;
use JustSteveKing\StatusCode\Http;
use Zenstruck\Browser\KernelBrowser;

trait TestHelper {
  private string $loginEndpoint = 'api/login_check';



  public function getToken(
    KernelBrowser $browser,
    string $username,
    string $password,
    array $roles
  ) {
    $req = $browser
      ->post($this->loginEndpoint, [
        'headers' => ['Content-Type' => 'application/json'],
        'json' => [
          'username' => $username,
          'password' => $password,
        ],
      ])
      ->assertStatus(Http::OK())
      ->assertJson();
    return $req->content();
    $response = $req->content();
    dd($response);


  }

}
