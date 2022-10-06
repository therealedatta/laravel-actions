<?php

namespace Therealedatta\LaravelActions\Tests\TestSupport;

use Illuminate\Routing\Router;
use Therealedatta\LaravelActions\Action;

class SimpleRoutesAction extends Action
{
    public static function routes(Router $router): void
    {
        $router->post('/my/action/endpoint', static::class);
    }

    public function handle(int $arg = 0): string
    {
        return 'ok handle arg '.$arg;
    }

    public function __invoke(int $arg = 0): string
    {
        $result = $this->handle($arg);

        return 'ok response, '.$result;
    }
}
