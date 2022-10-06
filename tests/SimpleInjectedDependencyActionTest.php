<?php

use Illuminate\Support\Facades\Route;
use Therealedatta\LaravelActions\Tests\TestSupport\SimpleInjectedDependencyAction;

it('can inject dependency in authorize, rules and invoke methods as controller', function () {
    Route::post('/simple-injected-dependency-action', SimpleInjectedDependencyAction::class);

    $this->post('/simple-injected-dependency-action')
         ->assertStatus(200)
         ->assertSee('injected!');
});

it('can inject dependency in authorize, rules and invoke methods as object', function () {
    $this->assertEquals(SimpleInjectedDependencyAction::run(), 'injected!');
});
