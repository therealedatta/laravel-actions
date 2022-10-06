<?php

namespace Therealedatta\LaravelActions;

use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Therealedatta\LaravelActions\Commands\ActionMakeCommand;
use Therealedatta\LaravelActions\Commands\StubPublishCommand;

class ActionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-actions')
            ->hasCommands(
                ActionMakeCommand::class,
                StubPublishCommand::class,
            )
            ->hasConfigFile('actions')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToStarRepoOnGitHub('therealedatta/laravel-actions');
            });
    }
}
