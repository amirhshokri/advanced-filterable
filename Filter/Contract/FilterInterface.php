<?php

namespace App\AdvancedFilters\Filter\Contract;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    /**
     * @param Builder $eloquentBuilder
     * @param array $requestParameters
     * @param array|null $acceptableFilterParameters
     * @return void
     */
    public function apply(Builder $eloquentBuilder, array $requestParameters, array $acceptableFilterParameters = null): void;
}