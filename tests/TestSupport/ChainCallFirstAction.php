<?php

namespace Therealedatta\LaravelActions\Tests\TestSupport;

use Therealedatta\LaravelActions\Action;

class ChainCallFirstAction extends Action
{
    public function handle($authorized = 0): array
    {
        $first = ['authorized' => $authorized, 'foo' => $this->foo, 'xxx' => $this->xxx, 'zzz' => $this->zzz];
        $second = ChainCallSecondAction::run();
        $third = ChainCallThirdAction::run(['xxx' => 'this is the xxx param arg', 'zzz' => 12]);
        $forth = ChainCallForthAction::run(['foo' => 'this is the foo param arg', 'zzz' => 7]);

        return [
            'first' => $first,
            'second' => $second,
            'third' => $third,
            'forth' => $forth,
        ];
    }

    public function __invoke(): array
    {
        return $this->handle($this->get('authorized', 0));
    }
}
