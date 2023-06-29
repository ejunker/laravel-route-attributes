<?php

namespace Spatie\RouteAttributes;

abstract class RouteGroup
{
    public ?string $prefix = null;

    public ?string $as = null;

    public ?string $domain = null;

    public array $middleware = [];

    public array $where = [];

    public function toArray(): array
    {
        return array_filter([
            'prefix' => $this->prefix,
            'as' => $this->as,
            'domain' => $this->domain,
            'middleware' => array_unique([...$this->middleware, ...$this->middleware()]),
            'where' => $this->where,
        ]);
    }

    public function middleware(): array
    {
        return [];
    }
}
