<?php

namespace App\Factory;

use App\Entity\Category;
use App\Entity\FortuneCookie;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<FortuneCookie>
 */
final class FortuneCookieFactory extends PersistentProxyObjectFactory
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
        return FortuneCookie::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'category' => CategoryFactory::new(),
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'discontinued' => self::faker()->boolean(),
            'fortune' => self::faker()->text(255),
            'numberPrinted' => self::faker()->randomNumber(),
            'owner' => UserFactory::random()
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(FortuneCookie $fortuneCookie): void {})
        ;
    }


}
