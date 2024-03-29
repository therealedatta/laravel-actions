<?php

use Illuminate\Support\Facades\Route;
use Therealedatta\LaravelActions\Tests\TestSupport\MiddlewareMethodAction;
use Therealedatta\LaravelActions\Tests\TestSupport\MiddlewarePropertyAction;
use Therealedatta\LaravelActions\Tests\TestSupport\SimpleInjectedDependencyAction;
use Therealedatta\LaravelActions\Tests\TestSupport\SimpleRulesAndAuthorizationAction;

it('passes authorization and validation as object', function () {
    $this->assertEquals(SimpleRulesAndAuthorizationAction::run(['foo' => 'some text']), 'ok');
});

it('passes authorization and validation', function () {
    Route::post('/simple-rules-and-auth-action', SimpleRulesAndAuthorizationAction::class);

    $this->post('/simple-rules-and-auth-action', ['foo' => 'some text'])
         ->assertStatus(200)
         ->assertSee('ok');
});

it('fails authorization', function () {
    Route::post('/simple-rules-and-auth-action', SimpleRulesAndAuthorizationAction::class);

    $this->post('/simple-rules-and-auth-action', ['authorized' => false])
         ->assertStatus(403)
         ->assertSee('This action is unauthorized');
});

it('fails validation', function () {
    Route::post('/simple-rules-and-auth-action', SimpleRulesAndAuthorizationAction::class);

    $this->postJson('/simple-rules-and-auth-action', ['bar' => 'some text'])
         ->assertStatus(422)
         ->assertJsonValidationErrors([
             'foo' => 'The foo field is required.',
             'bar', // => 'The bar field must be an integer.',  // translation differences between L9 and L10
         ]);
});

it('revalidates at each call', function () {
    Route::post('/simple-rules-and-auth-action', SimpleRulesAndAuthorizationAction::class);

    $this->postJson('/simple-rules-and-auth-action', ['authorized' => false])
        ->assertStatus(403);

    $this->postJson('/simple-rules-and-auth-action', ['foo' => 'some text'])
        ->assertStatus(200);

    $this->postJson('/simple-rules-and-auth-action', ['bar' => 'some text'])
        ->assertStatus(422);
});

it('revalidates at each call with different endpoints', function () {
    Route::post('/simple-rules-and-auth-action', SimpleRulesAndAuthorizationAction::class);
    Route::post('/simple-injected-dependency-action', SimpleInjectedDependencyAction::class);
    Route::get('/middleware-property-action', MiddlewarePropertyAction::class);
    Route::get('/middleware-method-action', MiddlewareMethodAction::class);

    $this->postJson('/simple-rules-and-auth-action', ['authorized' => false])
        ->assertStatus(403);

    $this->postJson('/simple-rules-and-auth-action', ['foo' => 'some text'])
        ->assertStatus(200);

    $this->get('/middleware-property-action?authorized=1')
        ->assertStatus(200)
        ->assertSee('Middleware has been passed');

    $this->get('/middleware-method-action?authorized=1')
        ->assertStatus(200)
        ->assertSee('Middleware has been passed');

    $this->postJson('/simple-rules-and-auth-action', ['bar' => 'some text'])
        ->assertStatus(422);

    $this->post('/simple-injected-dependency-action')
        ->assertStatus(200)
        ->assertSee('injected!');

    $this->get('/middleware-property-action?authorized=0')
        ->assertStatus(403)
        ->assertSee('Unauthorized from the middleware');

    $this->get('/middleware-method-action?authorized=0')
        ->assertStatus(403)
        ->assertSee('Unauthorized from the middleware');

    $this->postJson('/simple-rules-and-auth-action', ['foo' => 'some text'])
        ->assertStatus(200);
});
