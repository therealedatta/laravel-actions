<?php

namespace Therealedatta\LaravelActions\Tests\TestSupport;

use Therealedatta\LaravelActions\Action;

class MiddlewareMethodAction extends Action
{
    public function middleware()
    {
        return [
            IsAuthorizedMiddleware::class,
        ];
    }

    public function handle(): string
    {
        return 'Middleware has been passed';
    }

    public function __invoke(): string
    {
        return $this->handle();
    }
}
