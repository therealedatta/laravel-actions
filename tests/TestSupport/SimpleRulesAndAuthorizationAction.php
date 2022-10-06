<?php

namespace Therealedatta\LaravelActions\Tests\TestSupport;

use Therealedatta\LaravelActions\Action;

class SimpleRulesAndAuthorizationAction extends Action
{
    public function authorize(): bool
    {
        return $this->get('authorized', true);
    }

    public function rules(): array
    {
        return [
            'foo' => ['required', 'string', 'min:3'],
            'bar' => ['integer'],
        ];
    }

    public function handle(): string
    {
        $this->validate();

        return 'ok';
    }

    public function __invoke(): string
    {
        return $this->handle();
    }
}
