<?php

namespace App\Factory;

use App\Entity\Profile;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Profile>
 *
 * @method        Profile|Proxy create(array|callable $attributes = [])
 * @method static Profile|Proxy createOne(array $attributes = [])
 * @method static Profile|Proxy find(object|array|mixed $criteria)
 * @method static Profile|Proxy findOrCreate(array $attributes)
 * @method static Profile|Proxy first(string $sortedField = 'id')
 * @method static Profile|Proxy last(string $sortedField = 'id')
 * @method static Profile|Proxy random(array $attributes = [])
 * @method static Profile|Proxy randomOrCreate(array $attributes = [])
 * @method static EntityRepository|RepositoryProxy repository()
 * @method static Profile[]|Proxy[] all()
 * @method static Profile[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Profile[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Profile[]|Proxy[] findBy(array $attributes)
 * @method static Profile[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Profile[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class ProfileFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            'description' => self::faker()->text(),
            'firstName' => self::faker()->text(),
            'lastName' => self::faker()->text(),
            'user' => UserFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Profile $profile): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Profile::class;
    }
}
