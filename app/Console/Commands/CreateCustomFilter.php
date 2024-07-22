<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class CreateCustomFilter extends GeneratorCommand
{
    /**
     * @var string
     */
    protected $signature = 'make:custom-filter {name}';

    /**
     * @var string
     */
    protected $description = 'Creates a custom filter file for AdvancedFilterable trait.';

    /**
     * @var string
     */
    protected $type = 'Custom filter file';

    /**
     * @return string
     */
    protected function getNameInput(): string
    {
        $this->validateFileName();

        return ucfirst(trim($this->argument('name')));
    }

    /**
     * @return void
     */
    protected function validateFileName()
    {
        if (Str::endsWith($this->argument('name'), 'Filter') === false) {
            $this->error("Filename must end with 'Filter'. e.g. UserFilter");
            exit;
        }
    }

    /**
     * @param string $stub
     * @param $name
     * @return CreateCustomFilter
     */
    protected function replaceNamespace(&$stub, $name): CreateCustomFilter
    {
        $replace = [
            '{{ namespace }}' => 'App\AdvancedFilters\Filter\Custom',
            '{{ className }}' => $this->getNameInput(),
            '{{ mustExtendClass }}' => 'CustomFilter',
        ];

        $stub = str_replace(array_keys($replace), array_values($replace), $stub);

        return $this;
    }

    /**
     * @return string
     */
    protected function getStub(): string
    {
        return app_path() . '/Console/Commands/Stubs/CustomFilter.stub';
    }

    /**
     * Where to create file
     * @param string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return 'App\AdvancedFilters\Filter\Custom';
    }
}
