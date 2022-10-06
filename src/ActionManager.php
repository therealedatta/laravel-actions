<?php

namespace Therealedatta\LaravelActions;

use Illuminate\Routing\Router;

class ActionManager
{
    /**
     * Util to register the class as route in the route file
     * Needs to implement the static `routes` method in the action class
     *
     * Example: `Actions::registerRoutes(\App\MyAwesomeAction::class);`
     */
    public static function registerRoutes(string $class): void
    {
        $class::routes(app(Router::class));
    }
}
