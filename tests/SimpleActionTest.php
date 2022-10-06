<?php

use Illuminate\Support\Facades\Route;
use Therealedatta\LaravelActions\Tests\TestSupport\SimpleAction;

it('can call to simple invokable controller', function () {
    Route::post('/simple-action', SimpleAction::class);

    $this->post('/simple-action')
         ->assertStatus(200)
         ->assertSee('ok response, ok handle arg 0');
});

it('can call to simple invokable controller with params', function () {
    Route::post('/simple-action/{arg}', SimpleAction::class);

    $this->post('/simple-action/7')
         ->assertStatus(200)
         ->assertSee('ok response, ok handle arg 7');
});

it('can call to simple invokable controller with authorize method false by default', function () {
    config()->set('actions.authorize', false);

    Route::post('/simple-action', SimpleAction::class);

    $this->post('/simple-action')
         ->assertStatus(403);
});

it('can call to simple action as object without params', function () {
    $this->assertEquals(SimpleAction::run(), 'ok handle arg 0');
});

it('can call to simple action as object with params', function () {
    $this->assertEquals(SimpleAction::run(['arg' => 15]), 'ok handle arg 15');
});

it('can call to simple action as object using runIf', function () {
    $this->assertEquals(SimpleAction::runIf(true, ['arg' => 7]), 'ok handle arg 7');
    $this->assertNull(SimpleAction::runIf(false, ['arg' => 7]));
});

it('can call to simple action as object using runUnless', function () {
    $this->assertEquals(SimpleAction::runUnless(false, ['arg' => 7]), 'ok handle arg 7');
    $this->assertNull(SimpleAction::runUnless(true, ['arg' => 7]));
});
