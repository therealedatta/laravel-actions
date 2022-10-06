<?php

namespace Therealedatta\LaravelActions\Tests\TestSupport;

use Therealedatta\LaravelActions\Action;

class ChainCallForthAction extends Action
{
    public function authorize(): bool
    {
        return $this->get('authorized', false);
    }

    public function rules(): array
    {
        return [
            'foo' => ['required', 'string', 'min:3'],
            'bar' => ['integer'],
        ];
    }

    public function handle(): array
    {
        $this->validate();

        return ['authorized' => $this->authorized, 'foo' => $this->foo, 'xxx' => $this->xxx, 'zzz' => $this->zzz];
    }
}
