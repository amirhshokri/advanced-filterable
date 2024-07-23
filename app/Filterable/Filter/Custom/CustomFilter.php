<?php

namespace App\Filterable\Filter\Custom;

use App\Filterable\Filter\BaseFilter;
use App\Filterable\Filter\Contract\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

class CustomFilter extends BaseFilter implements FilterInterface
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

        foreach ($requestParameters["filters"] as $filterItem) {

            if($this->isParameterNameAcceptable($filterItem, $acceptableFilterParameters) === false){
                continue;
            }

            $name = $filterItem["name"];
            $operand = $filterItem["operand"];
            $value = $filterItem["value"];

            if (method_exists($this, $name) === false) {
                $this->prepareWhere($name, $operand, $value);
                continue;
            }

            $this->{$name}($value, $operand);
        }
    }
}
