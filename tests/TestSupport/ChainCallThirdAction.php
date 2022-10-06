<?php

namespace Therealedatta\LaravelActions\Tests\TestSupport;

use Therealedatta\LaravelActions\Action;

class ChainCallThirdAction extends Action
{
    protected array $middleware = [
        IsAuthorizedMiddleware::class,
    ];

    public function rules(): array
    {
        return [
            'xxx' => ['required', 'string', 'min:3'],
            'zzz' => ['required', 'integer'],
        ];
    }

    public function handle(SomeInjectedService $service): array
    {
        $this->validate();

        return ['authorized' => $this->authorized, 'foo' => $this->foo, 'xxx' => $this->xxx, 'zzz' => $this->zzz, 'injected' => $service instanceof SomeInjectedService];
    }
}
