<?php

use Illuminate\Support\Facades\Route;
use Therealedatta\LaravelActions\Tests\TestSupport\MiddlewarePropertyAction;

it('can check middleware conditions when arg not provided as controller', function () {
    Route::get('/middleware-property-action', MiddlewarePropertyAction::class);

    $this->get('/middleware-property-action')
         ->assertStatus(403)
         ->assertSee('Unauthorized from the middleware');
});

it('can check middleware conditions when arg is false as controller', function () {
    Route::get('/middleware-property-action', MiddlewarePropertyAction::class);

    $this->get('/middleware-property-action?authorized=0')
         ->assertStatus(403)
         ->assertSee('Unauthorized from the middleware');
});

it('can pass middleware and reach endpoint as controller', function () {
    Route::get('/middleware-property-action', MiddlewarePropertyAction::class);

    $this->get('/middleware-property-action?authorized=1')
         ->assertStatus(200)
         ->assertSee('Middleware has been passed');
});

it('can check middleware conditions when arg not provided as object', function () {
    MiddlewarePropertyAction::run();
})->throws(\Symfony\Component\HttpKernel\Exception\HttpException::class, 'Unauthorized from the middleware');

it('can check middleware conditions when arg is false as object', function () {
    MiddlewarePropertyAction::run(['authorized' => 0]);
})->throws(\Symfony\Component\HttpKernel\Exception\HttpException::class, 'Unauthorized from the middleware');

it('can pass middleware and reach endpoint as object', function () {
    $this->assertEquals(MiddlewarePropertyAction::run(['authorized' => 1]), 'Middleware has been passed');
});
