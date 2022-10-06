<?php

namespace Therealedatta\LaravelActions\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Therealedatta\LaravelActions\ActionManager
 */
class Actions extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Therealedatta\LaravelActions\ActionManager::class;
    }
}
