<?php

use Illuminate\Support\Facades\Route;
use Therealedatta\LaravelActions\Tests\TestSupport\MiddlewareAction;

it('can check middleware conditions when arg not provided as controller', function () {
    Route::get('/middleware-action', MiddlewareAction::class);

    $this->get('/middleware-action')
         ->assertStatus(403)
         ->assertSee('Unauthorized from the middleware');
});

it('can check middleware conditions when arg is false as controller', function () {
    Route::get('/middleware-action', MiddlewareAction::class);

    $this->get('/middleware-action?authorized=0')
         ->assertStatus(403)
         ->assertSee('Unauthorized from the middleware');
});

it('can pass middleware and reach endpoint as controller', function () {
    Route::get('/middleware-action', MiddlewareAction::class);

    $this->get('/middleware-action?authorized=1')
         ->assertStatus(200)
         ->assertSee('Middleware has been passed');
});

it('can check middleware conditions when arg not provided as object', function () {
    MiddlewareAction::run();
})->throws(\Symfony\Component\HttpKernel\Exception\HttpException::class, 'Unauthorized from the middleware');

it('can check middleware conditions when arg is false as object', function () {
    MiddlewareAction::run(['authorized' => 0]);
})->throws(\Symfony\Component\HttpKernel\Exception\HttpException::class, 'Unauthorized from the middleware');

it('can pass middleware and reach endpoint as object', function () {
    $this->assertEquals(MiddlewareAction::run(['authorized' => 1]), 'Middleware has been passed');
});
