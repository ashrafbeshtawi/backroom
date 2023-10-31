<?php

namespace App\Tests\src\Entity;

use App\Entity\PictureType;
use App\Factory\PictureTypeFactory;
use App\Factory\UserFactory;
use App\Utils\Roles;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Zenstruck\Browser\KernelBrowser;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\Test\ResetDatabase;
use JustSteveKing\StatusCode\Http;

class PictureTypeTest extends KernelTestCase {
  use HasBrowser;
  use ResetDatabase;

  private const BASE_URL = 'api/picture_types';
  private const TARGET_RESOURCE = PictureType::class;
  private const TARGET_RESOURCE_FACTORY = PictureTypeFactory::class;

  public function testGetPictureTypesCollection() {
    PictureTypeFactory::createMany(5);
    $this->browser()
      ->get('api/picture_types',[
        'headers' => ['Content-Type' => 'application/json']
      ])
      ->assertNotAuthenticated()
      ->assertStatus(Http::OK())
      ->assertJsonMatches('"hydra:totalItems"', 5);
  }

  /**
   * @dataProvider PictureTypeProvider
   * @return void
   */
  public function testGetPictureType(
    string $httpMethod,
    bool $createResource,
    bool $targetResource,
    bool $withUser,
    ?array $userRoles,
    int $httpCode,
    ?array $payload,
    bool $checkResponse
  ) {
    $browser = $this->browser();

    if ($createResource) {
      $resource = self::TARGET_RESOURCE_FACTORY::createOne();
    }
    if ($withUser) {
      $user = UserFactory::createOne(['roles' => $userRoles]);
      $browser
        ->actingAs($user)
        ->assertAuthenticated();
    }


    $browser = $browser->$httpMethod(
      self::BASE_URL . ($createResource && $targetResource ? '/' . $resource->getId() : ''),
      Utils::getOptions($payload)
    )
      ->assertStatus($httpCode);
    if ($checkResponse && $createResource) {
      $this->checkResponse($browser, $resource);
    };

  }

  private function getBasicPayload(): array {
    return [
      'name' => 'dummy',
      'limitedNumber' => true,
      'maxNumber' => 10
    ];
  }


  /**
   * Needed Arguments for the call:
   * int $httpMethod,
   * bool $createResource,
   * bool $targetResource,
   * bool $withUser,
   * ?array $userRoles,
   * int $httpCode,
   * ?array $payload,
   * bool $checkResponse
   * @return array
   */
  public function PictureTypeProvider()
  {
    return [
      [
        Utils::GET,
        true,
        true,
        true,
        [Roles::USER, Roles::ACTIVATED],
        Http::OK(),
        null,
        true
      ],
      [
        Utils::POST,
        false,
        false,
        false,
        null,
        Http::UNAUTHORIZED(),
        $this->getBasicPayload(),
        false
      ],
      [
        Utils::POST,
        false,
        false,
        true,
        [Roles::USER, Roles::ACTIVATED],
        Http::FORBIDDEN(),
        $this->getBasicPayload(),
        false
      ],
      [
        Utils::POST,
        false,
        false,
        true,
        [Roles::USER, Roles::ACTIVATED, Roles::ADMIN],
        Http::CREATED(),
        $this->getBasicPayload(),
        true
      ],
      [
        Utils::PUT,
        true,
        true,
        false,
        null,
        Http::UNAUTHORIZED(),
        $this->getBasicPayload(),
        false
      ],
      [
        Utils::PUT,
        true,
        true,
        true,
        [Roles::USER, Roles::ACTIVATED],
        Http::FORBIDDEN(),
        $this->getBasicPayload(),
        false
      ],
      [
        Utils::PUT,
        true,
        true,
        true,
        [Roles::USER, Roles::ACTIVATED, Roles::ADMIN],
        Http::OK(),
        $this->getBasicPayload(),
        false
      ],
      [
        Utils::DELETE,
        true,
        true,
        false,
        null,
        Http::UNAUTHORIZED(),
        null,
        false
      ],
      [
        Utils::DELETE,
        true,
        true,
        true,
        [Roles::USER, Roles::ACTIVATED],
        Http::FORBIDDEN(),
        null,
        false
      ],
      [
        Utils::DELETE,
        true,
        true,
        true,
        [Roles::USER, Roles::ACTIVATED, Roles::ADMIN],
        Http::NO_CONTENT(),
        null,
        false
      ],
    ];
  }

  private function checkResponse(KernelBrowser $browser, Proxy $resource) {
    $browser
      ->assertJsonMatches('id', $resource->getId())
      ->assertJsonMatches('name', $resource->getName())
      ->assertJsonMatches('limitedNumber', $resource->isLimitedNumber())
      ->assertJsonMatches('maxNumber', $resource->getMaxNumber());
  }


}
