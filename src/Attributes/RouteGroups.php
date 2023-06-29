<?php

namespace Spatie\RouteAttributes\Attributes;

use Attribute;
use Spatie\RouteAttributes\RouteGroup;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class RouteGroups implements RouteAttribute
{
    public function __construct(
        public array $routeGroupClasses,
        public ?string $prefix = null,
        public ?string $as = null,
        public ?string $domain = null,
        public array $middleware = [],
        public array $where = [],
    ) {
        foreach($this->routeGroupClasses as $routeGroupClass) {
            if (! class_exists($routeGroupClass) || ! is_subclass_of($routeGroupClass, RouteGroup::class)) {
                throw new \RuntimeException('$routeGroupClass must be an instance of RouteGroup');
            }
        }
    }

    public function toArray(): array
    {
        $groupArrays = [];
        foreach ($this->routeGroupClasses as $routeGroupClass) {
            $groupArrays[$routeGroupClass] = (new $routeGroupClass)->toArray();
        }

        $groupArrays['inline'] = array_filter([
            'prefix' => $this->prefix,
            'as' => $this->as,
            'domain' => $this->domain,
            'middleware' => $this->middleware,
            'where' => $this->where,
        ]);

        // merge route attributes from route groups
        return array_reduce($groupArrays, static function ($actionArray, $group) {
            return \Illuminate\Routing\RouteGroup::merge($group, $actionArray, prependExistingPrefix: true);
        }, []);
    }
}
