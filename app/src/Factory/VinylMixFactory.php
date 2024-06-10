<?php

namespace App\Factory;

use App\Entity\VinylMix;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<VinylMix>
 */
final class VinylMixFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return VinylMix::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'genre' => self::faker()->randomElement(['pop','rock']),
            'title' => self::faker()->words(5,true),
            'trackCount' => self::faker()->numberBetween(5,20),
            'votes' => self::faker()->numberBetween(-50,50),
            'description' => self::faker()->paragraph(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(VinylMix $vinylMix): void {})
        ;
    }
}
