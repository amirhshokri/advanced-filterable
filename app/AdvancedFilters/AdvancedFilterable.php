<?php

namespace App\AdvancedFilters;

use App\AdvancedFilters\Filter\Custom\CustomFilter;
use App\AdvancedFilters\Filter\Defaults\DefaultFilter;
use App\AdvancedFilters\Validator\RequestValidator;
use Exception;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method advancedFilter(CustomFilter $customFilter = null)
 * @method setRequestParameters(array $requestParameters)
 */
trait AdvancedFilterable
{
    /**
     * @param Builder $query
     * @param CustomFilter|null $customFilter
     * @return void
     * @throws Exception
     */
    public function scopeAdvancedFilter(Builder $query, CustomFilter $customFilter = null): void
    {
        $requestParameters = $this->getRequestParameters();

        RequestValidator::validate($requestParameters);

        $filter = $customFilter ?? (new DefaultFilter());

        $filter->apply($query, $requestParameters, $this->getAcceptableFilterParameters());
    }

    /**
     * @var array
     */
    protected array $requestParameters = [];

    /**
     * @param Builder $query
     * @param array $requestParameters
     * @return void
     */
    public function scopeSetRequestParameters(Builder $query, array $requestParameters)
    {
        $this->requestParameters = $requestParameters;
    }

    /**
     * @return array
     */
    private function getRequestParameters(): array
    {
        return (count($this->requestParameters) > 0) ? $this->requestParameters : request()->all();
    }

    /**
     * @return array|null
     */
    private function getAcceptableFilterParameters(): ?array
    {
        return (isset($this->advancedFilterableParameters)) ? $this->advancedFilterableParameters : null;
    }
}
