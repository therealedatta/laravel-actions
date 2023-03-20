<?php

namespace Therealedatta\LaravelActions\Concerns;

use Illuminate\Http\Request;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\App;

trait AsObject
{
    public static function make(): static
    {
        return app(static::class);
    }

    /**
     * `callAction` is not called by the framework before, so we do the job here
     *
     * @see static::handle()
     */
    public static function run(array $attributes = []): mixed
    {
        $request = request()->merge($attributes);

        $class_action = static::make();
        $class_action->prepareActionClass();
        $class_action->sendRequestThroughMiddleware($request);

        // @phpstan-ignore-next-line
        return App::call([$class_action, 'handle'], $class_action->getAttributesFromRequest($request));
    }

    public static function runIf(bool $boolean, array $attributes = []): mixed
    {
        return $boolean ? static::run($attributes) : null;
    }

    public static function runUnless(bool $boolean, array $attributes = []): mixed
    {
        return static::runIf(! $boolean, $attributes);
    }

    public function sendRequestThroughMiddleware(Request $request): void
    {
        app(Pipeline::class)
            ->send($request)
            ->through($this->middleware)
            ->thenReturn();
    }

    public function getAttributesFromRequest(Request $request): array
    {
        $route = $request->route();

        return array_merge(
            $route ? $route->parametersWithoutNulls() : [],
            $request->all()
        );
    }
}
