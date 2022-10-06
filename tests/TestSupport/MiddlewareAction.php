<?php

namespace Therealedatta\LaravelActions\Tests\TestSupport;

use Therealedatta\LaravelActions\Action;

class MiddlewareAction extends Action
{
    protected array $middleware = [
        IsAuthorizedMiddleware::class,
    ];

    public function handle(): string
    {
        return 'Middleware has been passed';
    }

    public function __invoke(): string
    {
        return $this->handle();
    }
}
