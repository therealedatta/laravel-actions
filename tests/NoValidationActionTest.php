<?php

use Illuminate\Support\Facades\Route;
use Therealedatta\LaravelActions\Tests\TestSupport\NoValidationAction;

it('works without data', function () {
    Route::get('/no-validation-action/{param?}', NoValidationAction::class);

    $this->get('/no-validation-action')
        ->assertStatus(200)
        ->assertExactJson([
            'method' => 'GET',
            'data' => [],
            'validated' => [],
            'param' => null,
            'service_injected' => true,
        ]);
});

it('works with route parameters', function () {
    Route::get('/no-validation-action/{param?}', NoValidationAction::class);

    $this->get('/no-validation-action/some_parameter')
        ->assertStatus(200)
        ->assertExactJson([
            'method' => 'GET',
            'data' => [],
            'validated' => [],
            'param' => 'some_parameter',
            'service_injected' => true,
        ]);
});

it('works with get data', function () {
    Route::get('/no-validation-action', NoValidationAction::class);

    $this->get('/no-validation-action?foo=bar')
        ->assertStatus(200)
        ->assertJson([
            'data' => ['foo' => 'bar'],
        ]);
});

it('works with post data', function () {
    Route::post('/no-validation-action', NoValidationAction::class);

    $this->post('/no-validation-action', ['foo' => 'bar'])
        ->assertStatus(200)
        ->assertJson([
            'data' => ['foo' => 'bar'],
        ]);
});

it('works without data as object', function () {
    $this->assertEquals(NoValidationAction::run(), [
        'method' => 'GET',
        'data' => [],
        'validated' => [],
        'param' => null,
        'service_injected' => true,
    ]);
});

it('works with route parameters as object', function () {
    $this->assertEquals(NoValidationAction::run(['param' => 'some_parameter']), [
        'method' => 'GET',
        'data' => ['param' => 'some_parameter'],
        'validated' => [],
        'param' => 'some_parameter',
        'service_injected' => true,
    ]);
});

it('works with route and attributes parameters as object', function () {
    $this->assertEquals(NoValidationAction::run(['param' => 'some_parameter', 'foo' => 'bar']), [
        'method' => 'GET',
        'data' => ['param' => 'some_parameter', 'foo' => 'bar'],
        'validated' => ['foo' => 'bar'],
        'param' => 'some_parameter',
        'service_injected' => true,
    ]);
});
