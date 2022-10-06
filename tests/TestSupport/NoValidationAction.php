<?php

namespace Therealedatta\LaravelActions\Tests\TestSupport;

use Therealedatta\LaravelActions\Action;

class NoValidationAction extends Action
{
    public function rules(): array
    {
        return [
            'foo' => ['nullable', 'string', 'min:3'],
            'bar' => ['integer'],
        ];
    }

    public function handle(SomeInjectedService $service, $param = null): array
    {
        $this->validate();

        return [
            'method' => $this->method(),
            'data' => $this->all(),
            'validated' => $this->validated(),
            'param' => $param,
            'service_injected' => $service instanceof SomeInjectedService,
        ];
    }

    public function __invoke(SomeInjectedService $service, $param = null): array
    {
        return $this->handle($service, $param);
    }
}
