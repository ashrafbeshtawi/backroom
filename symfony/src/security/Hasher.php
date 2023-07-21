<?php

namespace App\security;

class Hasher {
  public const HASH_LENGTH = 10;
  public const ALGORITHM = 'sha256';

  public static function generateActivationHash(string $baseHash): string {
    $activationHash = hash(
      Hasher::ALGORITHM,
      $baseHash . getenv('HASH_KEY')
    );
    $hashLength = min(strlen($activationHash), self::HASH_LENGTH);
    return substr(preg_replace('/[^0-9\']/', '', $activationHash), 0, $hashLength);
  }

  public static function isValidActivationHash(string $activationHash, string $baseHash): bool {
    $correctHash = self::generateActivationHash($baseHash);
    return $correctHash === $activationHash;
  }

}
