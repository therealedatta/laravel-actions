<?php

use Illuminate\Support\Facades\Route;
use Therealedatta\LaravelActions\Tests\TestSupport\ChainCallFirstAction;
use Therealedatta\LaravelActions\Tests\TestSupport\ChainCallSecondAction;

it('can call object actions as controller', function () {
    Route::post('/second-action', ChainCallSecondAction::class);

    $this->post('/second-action')
         ->assertStatus(403);

    $this->postJson('/second-action?authorized2=1', ['foo' => 'this is the foo request arg'])
        ->assertStatus(200)
        ->assertJson([
            'foo' => 'this is the foo request arg',
        ]);
});

it('can call actions as controller that call other action as objects', function () {
    Route::post('/first-action', ChainCallFirstAction::class);

    $this->postJson('/first-action')
         ->assertStatus(403); // in second call needs authorized2

    $this->postJson('/first-action?authorized2=1', ['foo' => 'this is the foo request arg'])
        ->assertStatus(403); // in third call needs authorized middleware

    $this->postJson('/first-action?authorized2=1&authorized=1', ['bar' => 'some text'])
         ->assertStatus(422)
         ->assertJsonValidationErrors([
             'foo' => 'The foo field is required.',
             'bar' => 'The bar field must be an integer.',
         ]);

    $this->postJson('/first-action?authorized2=1&authorized=1', ['foo' => 'this is the foo request arg'])
            ->assertStatus(200)
            ->assertExactJson([
                'first' => [
                    'foo' => 'this is the foo request arg',
                    'authorized' => '1',
                    'xxx' => null,
                    'zzz' => null,
                ],
                'second' => [
                    'foo' => 'this is the foo request arg',
                    'authorized' => '1',
                    'xxx' => null,
                    'zzz' => null,
                ],
                'third' => [
                    'foo' => 'this is the foo request arg',
                    'injected' => true,
                    'authorized' => '1',
                    'xxx' => 'this is the xxx param arg',
                    'zzz' => 12,
                ],
                'forth' => [
                    'foo' => 'this is the foo param arg',
                    'authorized' => '1',
                    'xxx' => 'this is the xxx param arg',
                    'zzz' => 7,
                ],
            ]);
});
