<?php

namespace Weble\LaravelPlaybooks\Command;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class MakePlaybookCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:playbook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Playbook';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Playbook';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/playbook.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        $namespace = config('playbooks.default_path', 'Playbooks');

        if (stripos($namespace, '\\') !== 0) {
            $namespace = $rootNamespace . '\\' . $namespace;
        }

        return $namespace;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the playbook'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [

        ];
    }
}
