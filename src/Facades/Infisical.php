<?php

namespace STS\Infisical\Facades;

use Illuminate\Support\Facades\Facade;
use STS\Infisical\InfisicalManager;

/**
 * @mixin InfisicalManager
 */
class Infisical extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return InfisicalManager::class;
    }
}
