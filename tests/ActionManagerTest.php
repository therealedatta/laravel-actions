<?php

use Therealedatta\LaravelActions\Facades\Actions;
use Therealedatta\LaravelActions\Tests\TestSupport\SimpleRoutesAction;

it('can register routes in the action file', function () {
    Actions::registerRoutes(SimpleRoutesAction::class);

    $this->post('/my/action/endpoint')
         ->assertStatus(200)
         ->assertSee('ok response, ok handle arg 0');
});
