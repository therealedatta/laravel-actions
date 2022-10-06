<?php

namespace Therealedatta\LaravelActions\Tests\TestSupport;

use Therealedatta\LaravelActions\Action;

class SimpleAction extends Action
{
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
