<?php

namespace Therealedatta\LaravelActions\Tests\TestSupport;

class SomeInjectedService
{
    public function __toString()
    {
        return 'injected!';
    }
}
