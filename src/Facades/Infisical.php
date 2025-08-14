<?php

namespace STS\Infisical\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \STS\Infisical\InfisicalManager
 */
class Infisical extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \STS\Infisical\InfisicalManager::class;
    }
}
