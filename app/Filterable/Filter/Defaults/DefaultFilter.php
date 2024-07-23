<?php

namespace App\Filterable\Filter\Defaults;

use App\Filterable\Filter\BaseFilter;
use App\Filterable\Filter\Contract\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class DefaultFilter extends BaseFilter implements FilterInterface
{
    /**
     * @param Builder $eloquentBuilder
     * @param array $requestParameters
     * @param array|null $acceptableFilterParameters
     * @return void
     */
    public function apply(Builder $eloquentBuilder, array $requestParameters, array $acceptableFilterParameters = null): void
    {
        if (isset($requestParameters["filters"]) === false) {
            return;
        }

        $this->eloquentBuilder = $eloquentBuilder;

        collect($requestParameters["filters"])
            ->filter(function ($filterItem) use ($acceptableFilterParameters) {
                return $this->isParameterNameAcceptable($filterItem, $acceptableFilterParameters);
            })
            ->map(function ($filterItem) {
                $this->prepareWhere($filterItem["name"], $filterItem["operand"], $filterItem["value"]);
            });
    }
}
