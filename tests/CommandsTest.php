<?php

beforeEach(function () {
    app()->setBasePath(implode(DIRECTORY_SEPARATOR, [__DIR__, 'TestSupport', 'base_path']));
    app()->useAppPath(implode(DIRECTORY_SEPARATOR, [__DIR__, 'TestSupport', 'base_path', 'app']));
});

afterEach(function () {
    (new \Illuminate\Filesystem\Filesystem)->deleteDirectory(implode(DIRECTORY_SEPARATOR, [__DIR__, 'TestSupport', 'base_path', 'app']));
    (new \Illuminate\Filesystem\Filesystem)->deleteDirectory(implode(DIRECTORY_SEPARATOR, [__DIR__, 'TestSupport', 'base_path', 'stubs']));
});

it('make:action command class exists', function () {
    $this->assertTrue(class_exists(\Therealedatta\LaravelActions\Commands\ActionMakeCommand::class));
});

it('can call make:action command', function () {
    $this->artisan('make:action MyAwesomeAction --force')->assertExitCode(0);
    $this->assertTrue(file_exists(app_path('Actions/MyAwesomeAction.php')));
});

it('can call make:action command with custom action path', function () {
    $this->artisan('actions:stubs --force')->assertExitCode(0);
    $this->artisan('make:action MyAwesomeAction --force')->assertExitCode(0);
    $this->assertTrue(file_exists(app_path('Actions/MyAwesomeAction.php')));
});

it('can call make:action command with subfolder', function () {
    $this->artisan('make:action Subfolder/MyAwesomeAction --force')->assertExitCode(0);
    $this->assertTrue(file_exists(app_path('Subfolder/Actions/MyAwesomeAction.php')));
});

it('can call make:action command without subfolder', function () {
    config()->set('actions.make_subfolder', null);
    $this->artisan('make:action Subfolder/MyAwesomeAction --force')->assertExitCode(0);
    $this->assertTrue(file_exists(app_path('Subfolder/MyAwesomeAction.php')));
});

it('can call make:action command with other subfolder', function () {
    config()->set('actions.make_subfolder', 'Actions2');
    $this->artisan('make:action Subfolder/MyAwesomeAction --force')->assertExitCode(0);
    $this->assertTrue(file_exists(app_path('Subfolder/Actions2/MyAwesomeAction.php')));
});

it('actions:stubs command class exists', function () {
    $this->assertTrue(class_exists(\Therealedatta\LaravelActions\Commands\StubPublishCommand::class));
});

it('can call actions:stubs command', function () {
    $this->artisan('actions:stubs --force')->assertExitCode(0);
    $this->assertTrue(file_exists(base_path('stubs/action.stub')));
});
