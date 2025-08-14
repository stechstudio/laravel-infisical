<?php

namespace STS\Infisical;

use Closure;

class InfisicalManager
{
    protected $environmentResolver;

    public function resolveEnvironmentUsing(callable $environmentResolver): static
    {
        $this->environmentResolver = $environmentResolver;

        return $this;
    }

    public function environment(?string $environmentSlug = null): string
    {
        if (!is_null($environmentSlug)) {
            return $environmentSlug;
        }

        if (is_callable($this->environmentResolver)) {
            return ($this->environmentResolver)();
        }

        return config('infisical.environment');
    }
}