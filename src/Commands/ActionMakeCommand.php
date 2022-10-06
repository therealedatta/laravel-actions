<?php

namespace Therealedatta\LaravelActions\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:action')]
class ActionMakeCommand extends GeneratorCommand
{
    protected $name = 'make:action';

    protected static $defaultName = 'make:action';

    protected $description = 'Create a new controller/request action class';

    /**
     * The type of class being generated.
     */
    protected $type = 'action';

    /**
     * Get the stub file for the generator.
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/action.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     */
    protected function resolveStubPath(string $stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    /**
     * Get the desired class name from the input.
     *
     * @return string
     */
    protected function getNameInput()
    {
        $name = trim(strval($this->argument('name')));
        $name = Str::replace('\\', '/', $name);
        $name = Str::replace('//', '/', $name);
        $name_array = explode('/', $name);

        $subfolder = config('actions.make_subfolder');

        if (! empty($subfolder)) {
            array_splice($name_array, count($name_array) - 1, 0, $subfolder);
        }

        return implode('/', $name_array);
    }

    /**
     * Get the console command arguments.
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the action already exists'],
            // ['subfolder', 's', InputOption::VALUE_OPTIONAL, 'The subfolder where the action should be created'],
        ];
    }
}
