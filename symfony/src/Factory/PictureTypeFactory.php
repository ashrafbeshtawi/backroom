<?php

namespace App\Factory;

use App\Entity\PictureType;
use App\Repository\PictureTypeRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<PictureType>
 *
 * @method        PictureType|Proxy create(array|callable $attributes = [])
 * @method static PictureType|Proxy createOne(array $attributes = [])
 * @method static PictureType|Proxy find(object|array|mixed $criteria)
 * @method static PictureType|Proxy findOrCreate(array $attributes)
 * @method static PictureType|Proxy first(string $sortedField = 'id')
 * @method static PictureType|Proxy last(string $sortedField = 'id')
 * @method static PictureType|Proxy random(array $attributes = [])
 * @method static PictureType|Proxy randomOrCreate(array $attributes = [])
 * @method static PictureTypeRepository|RepositoryProxy repository()
 * @method static PictureType[]|Proxy[] all()
 * @method static PictureType[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static PictureType[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static PictureType[]|Proxy[] findBy(array $attributes)
 * @method static PictureType[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static PictureType[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class PictureTypeFactory extends ModelFactory
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
            'limitedNumber' => self::faker()->boolean(),
            'name' => self::faker()->text(255),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(PictureType $pictureType): void {})
        ;
    }

    protected static function getClass(): string
    {
        return PictureType::class;
    }
}
