<?php

namespace Therealedatta\LaravelActions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Router;
use Therealedatta\LaravelActions\Concerns\AsObject;

abstract class Action extends FormRequest
{
    use AsObject;

    protected array $middleware = [];

    /**
     * Called before any routing method. We will use it to trigger
     * the steps to refresh the request and authorization
     */
    public function callAction(string $method, array $parameters): mixed
    {
        $this->prepareActionClass();

        return $this->{$method}(...array_values($parameters));
    }

    private function prepareActionClass(): void
    {
        $this->bindDefaultRules();
        $this->checkDefaultAuthorize();
        $this->refreshRequestAndAuthorize();
    }

    /**
     * we bind inside the container the method `authorize` returning true (or value in config)
     * to avoid unexpected error if `authorize` method does not exists in a controller
     */
    private function checkDefaultAuthorize(): void
    {
        if (method_exists(get_called_class(), 'authorize')) {
            return;
        }

        if (! boolval(config('actions.authorize'))) {
            $this->failedAuthorization();
        }
    }

    /**
     * we bind inside the container the method `rules` returning empty array
     * to avoid unexpected error if `rules` method does not exists in a controller
     */
    private function bindDefaultRules(): void
    {
        if (! method_exists(get_called_class(), 'rules')) {
            $this->container->bindMethod([get_called_class(), 'rules'], fn () => []);
        }
    }

    /**
     * Within callAction, we will:
     * 1. refresh the request (`createFrom`),
     * 2. we resolve the authorize method always
     * 3. we could start the automatic validation process with `parent::validateResolved();` as we disabled it with (`$this->validateResolved()`),
     *    but we will do this in the action handle itself to allow multiple endpoints in the same action (get and post)
     */
    protected function refreshRequestAndAuthorize(): void
    {
        static::createFrom(request(), $this);

        $this->passesAuthorization() ?: $this->failedAuthorization();

        // parent::validateResolved();
    }

    /**
     * We want to disable autovalidation because an action can handle multiple endpoints,
     * some of them will not need validation (example: get and post in same action)
     */
    public function validateResolved()
    {
        //
    }

    /**
     * Warning: automatic validation has been disabled when calling the action or object
     * 1. invalidate the cache of the latest resolved validator (`unset($this->validator)`) son we can call it more than in one request
     * 2. resolve again the validator and resolve it as if it is the first dependency injection resolution (`parent::validateResolved()`)
     * 3. return $this->validator->validated(); (already passed validation in validateResolved)
     */
    public function validate(): array
    {
        unset($this->validator);

        parent::validateResolved();

        return $this->validator->validated();
    }

    /**
     * Register middleware on the controller and return it
     */
    public function getMiddleware(): array
    {
        return array_map(function (string $middleware) {
            return [
                'middleware' => $middleware,
                'options' => [],
            ];
        }, $this->middleware);
    }

    /**
     * Used with `Actions::registerRoutes`
     */
    public static function routes(Router $router): void
    {
        //
    }
}
