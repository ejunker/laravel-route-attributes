<?php

namespace Spatie\RouteAttributes\Tests\TestClasses\Controllers;

use Spatie\RouteAttributes\Attributes\Route;
use Spatie\RouteAttributes\Attributes\ScopeBindings;

class BindingScoping2TestController
{
    #[Route('get', 'explicitly-enabled/{scoped}/{binding}')]
    #[ScopeBindings]
    public function explicitlyEnabledScopedBinding()
    {
    }

    #[Route('get', 'implicitly-disabled/{scoped}/{binding}')]
    public function implicitlyDisabledScopedBinding()
    {
    }
}
