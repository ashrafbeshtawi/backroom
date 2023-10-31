<?php

namespace App\Tests\src\Entity;

class Utils {
  public const GET = 'get';
  public const POST = 'post';
  public const PUT = 'put';
  public const DELETE = 'delete';

  public static function getBasicHeader(): array {
    return ['Content-Type' => 'application/json'];
  }

  public static function getOptions(?array $payload): array {
    $options = [
      'headers' => Utils::getBasicHeader(),
    ];
    if ($payload) {
      $options['json'] = $payload;
    }
    return $options;
  }
}
