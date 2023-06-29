<?php

namespace Spatie\RouteAttributes;

abstract class RouteGroup
{
    public ?string $prefix = null;

    public ?string $as = null;

    public ?string $domain = null;

    public array $middleware = [];

    public array $where = [];

    public array $routeGroups = [];

    public function toArray(): array
    {
        $groupArrays = [];
        foreach ($this->routeGroups as $routeGroup) {
            $groupArrays[$routeGroup] = (new $routeGroup)->toArray();
        }

        $groupArrays['inline'] = array_filter([
            'prefix' => $this->prefix,
            'as' => $this->as,
            'domain' => $this->domain,
            'middleware' => array_unique([...$this->middleware, ...$this->middleware()]),
            'where' => $this->where,
        ]);

        // merge route attributes from route groups
        return array_reduce($groupArrays, static function ($actionArray, $group) {
            return \Illuminate\Routing\RouteGroup::merge($group, $actionArray, prependExistingPrefix: true);
        }, []);
    }

    public function middleware(): array
    {
        return [];
    }
}
