<?php

namespace Therealedatta\LaravelActions\Tests\TestSupport;

use PHPUnit\Framework\TestCase as PHPUnit;
use Therealedatta\LaravelActions\Action;

/**
 * we will not allow dependency injection in rules and authorize to set those methods by default in Action class
 * if needed, the injected service can always be resolved from container
 */
class SimpleInjectedDependencyAction extends Action
{
    public function authorize(SomeInjectedService $service): bool
    {
        PHPUnit::assertTrue($service instanceof SomeInjectedService);

        return true;
    }

    public function rules(SomeInjectedService $service): array
    {
        PHPUnit::assertTrue($service instanceof SomeInjectedService);

        return [];
    }

    public function handle(SomeInjectedService $service): string
    {
        $this->validate();

        PHPUnit::assertTrue($service instanceof SomeInjectedService);

        return $service;
    }

    public function __invoke(SomeInjectedService $service): string
    {
        PHPUnit::assertTrue($service instanceof SomeInjectedService);

        return $this->handle($service);
    }
}
